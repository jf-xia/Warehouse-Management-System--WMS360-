@extends('master')

@section('title')
    {{$page_title}}
@endsection

@section('content')

    <!-- Custombox -->
    <link href="{{asset('assets/plugins/custombox/css/custombox.css')}}" rel="stylesheet">

    <!-- Modal-Effect -->
    <script src="{{asset('assets/plugins/custombox/js/custombox.min.js')}}"></script>
    <script src="{{asset('assets/plugins/custombox/js/legacy.min.js')}}"></script>

    <div class="content-page" xmlns:v-on="http://www.w3.org/1999/xhtml">

        <!-- Start content -->
        <div class="content">
            <div class="container-fluid">

            <div class="row m-t-20">
                <div class="col-md-12">


                    <div class="shelf-wise-order shadow">

                        <ul class="nav nav-tabs shelf-tab-btn" role="tablist">
                            <li class="nav-item w-50 text-center">
                                <a class="nav-link active" data-toggle="tab" href="#user_list">User</a>
                            </li>
                            <li class="nav-item w-50 text-center">
                                <a class="nav-link" data-toggle="tab" href="#role_list">Role</a>
                            </li>
                        </ul>
                        <div class="container-fluid tab-content shelf-content product-content">
                            <div id="user_list" class="tab-pane active m-b-20"><br>

                                 <!--screen option-->
                                <div class="card-box screen-option-content" style="display: none">

                                    <!---------------------------ON OFF SWITCH BUTTON AREA------------------------>
                                    <!--------------------------------------------------------------------------->

                                    <div class="d-flex justify-content-between content-inner mt-2 mb-2">
                                        <div class="d-block">
                                            <div class="d-flex align-items-center">
                                                <div class="onoffswitch">
                                                    <input type="checkbox" name="employee-id" class="onoffswitch-checkbox" id="employee-id" tabindex="0" @if(isset($setting['user']['user_list']['employee-id']) && $setting['user']['user_list']['employee-id'] == 1) checked @elseif(isset($setting['user']['user_list']['employee-id']) && $setting['user']['user_list']['employee-id'] == 0) @else checked @endif>
                                                    <label class="onoffswitch-label" for="employee-id">
                                                        <span class="onoffswitch-inner"></span>
                                                        <span class="onoffswitch-switch"></span>
                                                    </label>
                                                </div>
                                                <div class="ml-1"><p>Employee id</p></div>
                                            </div>
                                            <div class="d-flex align-items-center mt-2">
                                                <div class="onoffswitch">
                                                    <input type="checkbox" name="image" class="onoffswitch-checkbox" id="image" tabindex="0" @if(isset($setting['user']['user_list']['image']) && $setting['user']['user_list']['image'] == 1) checked @elseif(isset($setting['user']['user_list']['image']) && $setting['user']['user_list']['image'] == 0) @else checked @endif>
                                                    <label class="onoffswitch-label" for="image">
                                                        <span class="onoffswitch-inner"></span>
                                                        <span class="onoffswitch-switch"></span>
                                                    </label>
                                                </div>
                                                <div class="ml-1"><p>Image</p></div>
                                            </div>
                                        </div>
                                        <div class="d-block">
                                            <div class="d-flex align-items-center mt-sm-10">
                                                <div class="onoffswitch">
                                                    <input type="checkbox" name="first-name" class="onoffswitch-checkbox" id="first-name" tabindex="0" @if(isset($setting['user']['user_list']['first-name']) && $setting['user']['user_list']['first-name'] == 1) checked @elseif(isset($setting['user']['user_list']['first-name']) && $setting['user']['user_list']['first-name'] == 0) @else checked @endif>
                                                    <label class="onoffswitch-label" for="first-name">
                                                        <span class="onoffswitch-inner"></span>
                                                        <span class="onoffswitch-switch"></span>
                                                    </label>
                                                </div>
                                                <div class="ml-1"><p>First Name</p></div>
                                            </div>
                                            <div class="d-flex align-items-center mt-2">
                                                <div class="onoffswitch">
                                                    <input type="checkbox" name="last-name" class="onoffswitch-checkbox" id="last-name" tabindex="0" @if(isset($setting['user']['user_list']['last-name']) && $setting['user']['user_list']['last-name'] == 1) checked @elseif(isset($setting['user']['user_list']['last-name']) && $setting['user']['user_list']['last-name'] == 0) @else checked @endif>
                                                    <label class="onoffswitch-label" for="last-name">
                                                        <span class="onoffswitch-inner"></span>
                                                        <span class="onoffswitch-switch"></span>
                                                    </label>
                                                </div>
                                                <div class="ml-1"><p>Last Name</p></div>
                                            </div>
                                        </div>
                                        <div class="d-block">
                                            <div class="d-flex align-items-center mt-xs-10">
                                                <div class="onoffswitch">
                                                    <input type="checkbox" name="email" class="onoffswitch-checkbox" id="email" tabindex="0" @if(isset($setting['user']['user_list']['email']) && $setting['user']['user_list']['email'] == 1) checked @elseif(isset($setting['user']['user_list']['email']) && $setting['user']['user_list']['email'] == 0) @else checked @endif>
                                                    <label class="onoffswitch-label" for="email">
                                                        <span class="onoffswitch-inner"></span>
                                                        <span class="onoffswitch-switch"></span>
                                                    </label>
                                                </div>
                                                <div class="ml-1"><p>Email</p></div>
                                            </div>
                                            <div class="d-flex align-items-center mt-2">
                                                <div class="onoffswitch">
                                                    <input type="checkbox" name="phone" class="onoffswitch-checkbox" id="phone" tabindex="0" @if(isset($setting['user']['user_list']['phone']) && $setting['user']['user_list']['phone'] == 1) checked @elseif(isset($setting['user']['user_list']['phone']) && $setting['user']['user_list']['phone'] == 0) @else checked @endif>
                                                    <label class="onoffswitch-label" for="phone">
                                                        <span class="onoffswitch-inner"></span>
                                                        <span class="onoffswitch-switch"></span>
                                                    </label>
                                                </div>
                                                <div class="ml-1"><p>Phone</p></div>
                                            </div>
                                        </div>
                                        <div class="d-block">
                                            <div class="d-flex align-items-center role-view">
                                                <div class="onoffswitch">
                                                    <input type="checkbox" name="role" class="onoffswitch-checkbox" id="role" tabindex="0" @if(isset($setting['user']['user_list']['role']) && $setting['user']['user_list']['role'] == 1) checked @elseif(isset($setting['user']['user_list']['role']) && $setting['user']['user_list']['role'] == 0) @else checked @endif>
                                                    <label class="onoffswitch-label" for="role">
                                                        <span class="onoffswitch-inner"></span>
                                                        <span class="onoffswitch-switch"></span>
                                                    </label>
                                                </div>
                                                <div class="ml-1"><p>Role</p></div>
                                            </div>
                                        </div>
                                    </div>

                                    <!---------------------------END ON OFF SWITCH BUTTON AREA------------------------>
                                    <!--------------------------------------------------------------------------->

                                    <!----ON OFF SWITCH ARRAY KEY DECLARATION---->
                                    <input type="hidden" id="firstKey" value="user">
                                    <input type="hidden" id="secondKey" value="user_list">
                                    <!----END ON OFF SWITCH ARRAY KEY DECLARATION---->

                                    <!--pagination count, apply button and add user button-->
                                    <div class="d-flex justify-content-between align-items-center pagination-content">
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
                                        <div class="mt-xs-15">
                                            <a href="#addUser" data-animation="slit" data-plugin="custommodal" data-overlaySpeed="100" data-overlayColor="#36404a"><button class="btn btn-default">Add User</button></a>&nbsp;
                                        </div>
                                    </div>
                                    <!--End pagination count, apply button and add user button-->

                                </div>

                                <!--Breadcrumb section-->
                                <div class="screen-option py-4">
                                    <div class="d-flex justify-content-start align-items-center">
                                        <ol class="breadcrumb page-breadcrumb">
                                            <li class="breadcrumb-item active" aria-current="page">User</li>
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


                                    <div class="table-responsive">

                                        <!--Start Backend error handler-->
                                        @if($errors->any())
                                            <div  class="alert alert-danger alert-dismissible fade show" role="alert">
                                                <ul>
                                                    @foreach($errors->all() as $error)
                                                        <li>{{$error}}</li>
                                                    @endforeach
                                                </ul>
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                        @endif


                                        @if(Session::has('user_add_success_msg'))
                                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                                {!! Session::get('user_add_success_msg') !!}
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                        @endif


                                        @if (Session::has('user_update_success_msg'))
                                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                                {!! Session::get('user_update_success_msg') !!}
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                        @endif


                                        @if (Session::has('user_delete_success_msg'))
                                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                                {!! Session::get('user_delete_success_msg') !!}
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
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


                                        @if(Session::has('message'))
                                            <div class="alert alert-danger">
                                                <button type="button" class="close" data-dismiss="alert">×</button>
                                                <strong>{!! Session::get('message') !!}</strong>
                                            </div>
                                        @endif

                                        @if(Session::has('child_user_error'))
                                            <div class="alert alert-danger">
                                                <button type="button" class="close" data-dismiss="alert">×</button>
                                                <strong>{!! Session::get('child_user_error') !!}</strong>
                                            </div>
                                        @endif


                                        <!--End Backend error handler-->

                                        <div class="m-b-10 m-t-10">
                                            <!--start table upper side content-->
                                            <div class="d-flex justify-content-between product-inner p-b-10">
                                                {{--                                <div class="row-wise-search mb-sm-10">--}}
                                                {{--                                    <input class="form-control mb-1" id="row-wise-search" type="text" placeholder="Search....">--}}
                                                {{--                                </div>--}}
                                                <div class="draft-search-form">
                                                    <form class="d-flex" action="{{URL('user/id/name/search')}}" method="post">
                                                        @csrf
                                                        <div class="p-text-area">
                                                            <input type="text" name="search_value" id="search_value" class="form-control" placeholder="Search by Employee ID, Name...">
                                                        </div>
                                                        <input type="hidden" name="route_name" value="user-list">
                                                        <div class="submit-btn">
                                                            <button type="submit" class="search-btn waves-effect waves-light" onclick="supplier_name_search()">Search</button>
                                                        </div>
                                                    </form>
                                                </div>

                                                <!--Pagination area-->
                                                <div class="pagination-area">
                                                    <form action="{{url('pagination-all')}}" method="post">
                                                        @csrf
                                                        <div class="datatable-pages d-flex align-items-center">
                                                            <span class="displaying-num">{{$all_user->total()}} Users</span>
                                                            <span class="pagination-links d-flex">
                                                                @if($all_user->currentPage() > 1)
                                                                <a class="first-page btn {{$all_user->currentPage() > 1 ? '' : 'disable'}}" href="{{$all_decode_user->first_page_url}}" data-toggle="tooltip" data-placement="top" title="First Page">
                                                                    <span class="screen-reader-text d-none">First page</span>
                                                                    <span aria-hidden="true">«</span>
                                                                </a>
                                                                <a class="prev-page btn {{$all_user->currentPage() > 1 ? '' : 'disable'}}" href="{{$all_decode_user->prev_page_url}}" data-toggle="tooltip" data-placement="top" title="Previous Page">
                                                                    <span class="screen-reader-text d-none">Previous page</span>
                                                                    <span aria-hidden="true">‹</span>
                                                                </a>
                                                                @endif
                                                                <span class="paging-input d-flex align-items-center">
                                                                    <label for="current-page-selector" class="screen-reader-text d-none">Current Page</label>
                                                                    <input class="current-page" id="current-page-selector" type="text" name="paged" value="{{$all_decode_user->current_page}}" size="3" aria-describedby="table-paging">
                                                                    <span class="datatable-paging-text d-flex"> of <span class="total-pages">{{$all_decode_user->last_page}}</span></span>
                                                                    <input type="hidden" name="route_name" value="user-list">
                                                                </span>
                                                                @if($all_user->currentPage() !== $all_user->lastPage())
                                                                <a class="next-page btn" href="{{$all_decode_user->next_page_url}}" data-toggle="tooltip" data-placement="top" title="Next Page">
                                                                    <span class="screen-reader-text d-none">Next page</span>
                                                                    <span aria-hidden="true">›</span>
                                                                </a>
                                                                <a class="last-page btn" href="{{$all_decode_user->last_page_url}}" data-toggle="tooltip" data-placement="top" title="Last Page">
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
                                        </div>


                                        <!--start table section-->
                                        <table id="table-sort-list" class="w-100 product-table">
                                            <!--start table header section-->
                                            <thead>
                                            <tr>
                                                <th class="employee-id" style="text-align: center !important;" onclick="sortTable(0)">
                                                    <div class="d-flex justify-content-center">
                                                        <div class="btn-group">
                                                            <form action="{{URL('system/user/search')}}" method="post">
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
                                                                    <input type="hidden" name="column_name" value="employee_id">
                                                                    <input type="hidden" name="route_name" value="user-list">
                                                                    <button type="submit" class="btn btn-primary filter-apply-btn float-right">Apply <i class="fa fa-arrow-circle-right ml-1"></i></button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                        <div>Employee Id</div>
                                                    </div>
                                                </th>
                                                <th class="image" style="text-align: center !important;" onclick="sortTable(0)">Image</th>
                                                <th class="first-name" onclick="sortTable(0)">
                                                    <div class="d-flex justify-content-start">
                                                        <div class="btn-group">
                                                            <form action="{{URL('system/user/search')}}" method="post">
                                                                @csrf
                                                                <a type="button" class="dropdown-toggle filter-btn" data-toggle="dropdown">
                                                                    <i class="fa" aria-hidden="true"></i>
                                                                </a>
                                                                <div class="dropdown-menu filter-content shadow" role="menu">
                                                                    <p>Filter Value</p>
                                                                    <input type="text" class="form-control input-text" name="search_value">
                                                                    <div class="checkbox checkbox-custom checkbox m-t-10 m-b-10">
                                                                        <input id="opt-out2" type="checkbox" name="opt_out" value="1"><label for="opt-out2">Opt Out</label>
                                                                    </div>
                                                                    <input type="hidden" name="column_name" value="name">
                                                                    <input type="hidden" name="route_name" value="user-list">
                                                                    <button type="submit" class="btn btn-primary filter-apply-btn float-right">Apply <i class="fa fa-arrow-circle-right ml-1"></i></button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                        <div> First Name </div>
                                                    </div>
                                                </th>
                                                <th class="last-name" onclick="sortTable(0)">
                                                    <div class="d-flex justify-content-start">
                                                        <div class="btn-group">
                                                            <form action="{{URL('system/user/search')}}" method="post">
                                                                @csrf
                                                                <a type="button" class="dropdown-toggle filter-btn" data-toggle="dropdown">
                                                                    <i class="fa" aria-hidden="true"></i>
                                                                </a>
                                                                <div class="dropdown-menu filter-content shadow" role="menu">
                                                                    <p>Filter Value</p>
                                                                    <input type="text" class="form-control input-text" name="search_value">
                                                                    <div class="checkbox checkbox-custom checkbox m-t-10 m-b-10">
                                                                        <input id="opt-out3" type="checkbox" name="opt_out" value="1"><label for="opt-out3">Opt Out</label>
                                                                    </div>
                                                                    <input type="hidden" name="column_name" value="last_name">
                                                                    <input type="hidden" name="route_name" value="user-list">
                                                                    <button type="submit" class="btn btn-primary filter-apply-btn float-right">Apply <i class="fa fa-arrow-circle-right ml-1"></i></button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                        <div> Last Name </div>
                                                    </div>
                                                </th>
                                                <th class="email" onclick="sortTable(0)">
                                                    <div class="d-flex justify-content-start">
                                                        <div class="btn-group">
                                                            <form action="{{URL('system/user/search')}}" method="post">
                                                                @csrf
                                                                <a type="button" class="dropdown-toggle filter-btn" data-toggle="dropdown">
                                                                    <i class="fa" aria-hidden="true"></i>
                                                                </a>
                                                                <div class="dropdown-menu filter-content shadow" role="menu">
                                                                    <p>Filter Value</p>
                                                                    <input type="text" class="form-control input-text" name="search_value">
                                                                    <div class="checkbox checkbox-custom checkbox m-t-10 m-b-10">
                                                                        <input id="opt-out4" type="checkbox" name="opt_out" value="1"><label for="opt-out4">Opt Out</label>
                                                                    </div>
                                                                    <input type="hidden" name="column_name" value="email">
                                                                    <input type="hidden" name="route_name" value="user-list">
                                                                    <button type="submit" class="btn btn-primary filter-apply-btn float-right">Apply <i class="fa fa-arrow-circle-right ml-1"></i></button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                        <div> Email </div>
                                                    </div>
                                                </th>
                                                <th class="phone" onclick="sortTable(0)">
                                                    <div class="d-flex justify-content-start">
                                                        <div class="btn-group">
                                                            <form action="{{URL('system/user/search')}}" method="post">
                                                                @csrf
                                                                <a type="button" class="dropdown-toggle filter-btn" data-toggle="dropdown">
                                                                    <i class="fa" aria-hidden="true"></i>
                                                                </a>
                                                                <div class="dropdown-menu filter-content shadow" role="menu">
                                                                    <p>Filter Value</p>
                                                                    <input type="number" class="form-control input-text" name="search_value">
                                                                    <div class="checkbox checkbox-custom checkbox m-t-10 m-b-10">
                                                                        <input id="opt-out5" type="checkbox" name="opt_out" value="1"><label for="opt-out5">Opt Out</label>
                                                                    </div>
                                                                    <input type="hidden" name="column_name" value="phone_no">
                                                                    <input type="hidden" name="route_name" value="user-list">
                                                                    <button type="submit" class="btn btn-primary filter-apply-btn float-right">Apply <i class="fa fa-arrow-circle-right ml-1"></i></button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                        <div> Phone </div>
                                                    </div>
                                                </th>
                                                <th class="role" onclick="sortTable(0)">Role</th>
                                                <th style="width: 8%">Actions</th>
                                            </tr>
                                            </thead>
                                            <!--End table header section-->

                                            <!--start table body section-->
                                            <tbody id="table-body">
                                                <?php
                                                    foreach ($all_user as $user){
                                                ?>
                                                    <tr>
                                                        <td class="employee-id" style="text-align: center !important;">{{$user->employee_id}}</td>
                                                        <td class="image text-center" style="text-align: center !important;">
                                                            <a href="{{asset($user->image ? 'uploads/'.$user->image : 'assets/common-assets/no_image.jpg')}}" target="_blank"><img class="product-img" src="{{asset($user->image ? 'uploads/'.$user->image : 'assets/common-assets/no_image.jpg')}}" alt="contact-img" title="contact-img" class="rounded-circle thumb-sm" /></a>
                                                        </td>
                                                        <td class="first-name text-left">{{$user->name}}</td>
                                                        <td class="last-name">{{$user->last_name}}</td>
                                                        <td class="email">{{$user->email}}</td>
                                                        <td class="phone">{{$user->phone_no}}</td>
                                                            <?php
                                                            $data = '';
                                                            foreach($user->roles as $role){
                                                                $data .= $role->role_name.',';
                                                                }
                                                            ?>
                                                        <td class="role">{{rtrim($data,',')}}</td>
                                                        <td style="width: 8%">
                                                            @if (Auth::check() && in_array('1',explode(',',Auth::user()->role)))
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
                                                                                    <a class="btn-size edit-btn" href="#editUserList{{$user->id}}" data-animation="slit" data-plugin="custommodal" data-overlaySpeed="100" data-overlayColor="#36404a"  data-placement="top" title="Edit"><i class="fa fa-edit" aria-hidden="true"></i></a>
                                                                                </div>
                                                                                <div class="align-items-center mr-2">
                                                                                    <a class="btn-size view-btn" href="{{url('user-details/'.Crypt::encrypt($user->id))}}" target="_blank" data-toggle="tooltip" data-placement="top" title="View"><i class="fa fa-eye" aria-hidden="true"></i></a>
                                                                                </div>
                                                                                <div class="align-items-center mr-2">
                                                                                    <a class="btn-size change-pass-btn" href="{{url('user/change-password/'.$user->id)}}" target="_blank" data-toggle="tooltip" data-placement="top" title="Change Password"><i class="fa fa-key" aria-hidden="true"></i></a>
                                                                                </div>
                                                                                <div class="align-items-center">
                                                                                    <form action="{{url('delete-user')}}" method="post">
                                                                                        @csrf
                                                                                        <button class="btn-size del-pub delete-btn" style="cursor: pointer" href="#" data-toggle="tooltip" data-placement="top" title="Delete" onclick="return check_delete('user');"><i class="fa fa-trash" aria-hidden="true"></i></button>
                                                                                        <input type="hidden" name="user_id" value="{{$user->id}}">
                                                                                    </form>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <!--End dropup content-->
                                                                </div>
                                                                <!--End manage button area-->


                                                                <!-- Edit User Modal -->
                                                                <div id="editUserList{{$user->id}}" class="modal-demo">
                                                                    <button type="button" class="close" onclick="Custombox.close();">
                                                                        <span>&times;</span><span class="sr-only">Close</span>
                                                                    </button>
                                                                    <h4 class="custom-modal-title">Edit User</h4>
                                                                    <form role="form" class="vendor-form mobile-responsive" action="{{url('update-user/'.$user->id)}}" method="POST" enctype="multipart/form-data" data-parsley-validate>
                                                                        @csrf
                                                                        <div class="form-group row">
                                                                            <div class="col-md-1"></div>
                                                                            <label for="image" class="col-md-3 col-form-label ml-sm-25 mr-sm-25 ml-xs-25 mr-xs-25">Select Image</label>
                                                                            <div class="col-md-7 ml-sm-25 mr-sm-25 ml-xs-25 mr-xs-25">
                                                                                <div class="custom-file">
                                                                                    <input type="file" class="custom-file-input" id="imgInp" name="user_image">
                                                                                    <label class="custom-file-label" for="customFile">Choose image</label>
                                                                                </div>
                                                                                <img class="rounded mt-2 float-left" id="user_edit_image" src="{{asset($user->image ? 'uploads/'.$user->image : 'assets/common-assets/no_image.jpg')}}" alt="Image" width="150px" height="120px">
                                                                                <img id="blah" class="rounded" src="#" alt="Images" width="150px" height="120px" style="display: none;">
                                                                            </div>
                                                                            <div class="col-md-1"></div>
                                                                        </div>

                                                                        <div class="form-group row">
                                                                            <div class="col-md-1"></div>
                                                                            <label for="employee_id" class="col-md-3 col-form-label ml-sm-25 mr-sm-25 ml-xs-25 mr-xs-25">Employee Id</label>
                                                                            <div class="col-md-7 ml-sm-25 mr-sm-25 ml-xs-25 mr-xs-25">
                                                                                <input type="text" name="employee_id" class="form-control" id="employee_id" value="{{$user->employee_id ? $user->employee_id : old('employee_id')}}" placeholder="Enter Employee ID">
                                                                            </div>
                                                                            <div class="col-md-1"></div>
                                                                        </div>

                                                                        <div class="form-group row">
                                                                            <div class="col-md-1"></div>
                                                                            <label for="first_name" class="col-md-3 col-form-label ml-sm-25 mr-sm-25 ml-xs-25 mr-xs-25 required">First Name</label>
                                                                            <div class="col-md-7 ml-sm-25 mr-sm-25 ml-xs-25 mr-xs-25">
                                                                                <input type="text" name="name" class="form-control" id="name" value="{{$user->name ? $user->name : old('name')}}" placeholder="Enter First Name" required>
                                                                            </div>
                                                                            <div class="col-md-1"></div>
                                                                        </div>

                                                                        <div class="form-group row">
                                                                            <div class="col-md-1"></div>
                                                                            <label for="last_name" class="col-md-3 col-form-label ml-sm-25 mr-sm-25 ml-xs-25 mr-xs-25 required">Last Name</label>
                                                                            <div class="col-md-7 ml-sm-25 mr-sm-25 ml-xs-25 mr-xs-25">
                                                                                <input type="text" name="last_name" class="form-control" id="last_name" value="{{$user->last_name ? $user->last_name : old('last_name')}}" placeholder="Enter Last Name" required>
                                                                            </div>
                                                                            <div class="col-md-1"></div>
                                                                        </div>

                                                                        <div class="form-group row">
                                                                            <div class="col-md-1"></div>
                                                                            <label for="email" class="col-md-3 col-form-label ml-sm-25 mr-sm-25 ml-xs-25 mr-xs-25 required">Email Address</label>
                                                                            <div class="col-md-7 ml-sm-25 mr-sm-25 ml-xs-25 mr-xs-25">
                                                                                <input type="email" name="email" class="form-control" id="email" value="{{$user->email ? $user->email : old('email')}}" placeholder="Enter Email" required>
                                                                            </div>
                                                                            <div class="col-md-1"></div>
                                                                        </div>

            {{--                                                            <div class="form-group row">--}}
            {{--                                                                <div class="col-md-1"></div>--}}
            {{--                                                                <label for="password" class="col-md-3 col-form-label required">Password</label>--}}
            {{--                                                                <div class="col-md-7 ml-sm-10 mr-sm-10 ml-xs-10 mr-xs-10 wow pulse">--}}
            {{--                                                                    <input type="password" data-parsley-minlength="8" name="password" class="form-control" id="password" placeholder="Password" data-parsley-required />--}}
            {{--                                                                </div>--}}
            {{--                                                                <div class="col-md-1"></div>--}}
            {{--                                                            </div>--}}

            {{--                                                            <div class="form-group row">--}}
            {{--                                                                <div class="col-md-1"></div>--}}
            {{--                                                                <label for="password_confirmation" class="col-md-3 col-form-label required">Confirm Password</label>--}}
            {{--                                                                <div class="col-md-7 ml-sm-10 mr-sm-10 ml-xs-10 mr-xs-10 wow pulse">--}}
            {{--                                                                    <input type="password" data-parsley-minlength="8" name="password_confirmation"  class="form-control" id="password_confirmation" placeholder="Password confirmation" data-parsley-required />--}}
            {{--                                                                </div>--}}
            {{--                                                                <div class="col-md-1"></div>--}}
            {{--                                                            </div>--}}

                                                                        <div class="form-group row">
                                                                            <div class="col-md-1"></div>
                                                                            <label for="role" class="col-md-3 col-form-label ml-sm-25 mr-sm-25 ml-xs-25 mr-xs-25 required">Role</label>
                                                                            <div class="col-md-7 ml-sm-25 mr-sm-25 ml-xs-25 mr-xs-25">

                                                                                <div class="wms-row user-row">
                                                                                    @isset($all_role)
                                                                                        @foreach($all_role as $role)
                                                                                            <?php
                                                                                            $temp = '';
                                                                                            ?>
                                                                                            @foreach($user->roles as $roles)
                                                                                                @if($role->id == $roles->id)
                                                                                                    <div class="wms-col-4 user-checkbox">
                                                                                                        <input type="checkbox" name="role[]" value="{{$roles->id}}" checked>&nbsp;{{$roles->role_name}}
                                                                                                    </div>
                                                                                                    <?php
                                                                                                    $temp = 1;
                                                                                                    ?>
                                                                                                @endif
                                                                                            @endforeach
                                                                                            @if($temp == null)
                                                                                                <div class="wms-col-4 user-checkbox">
                                                                                                    <input type="checkbox" name="role[]" value="{{$role->id}}">{{$role->role_name}}
                                                                                                </div>
                                                                                            @endif
                                                                                        @endforeach
                                                                                    @endisset
                                                                                </div>

                                                                            </div>
                                                                            <div class="col-md-1"></div>
                                                                        </div>

                                                                        <div class="form-group row">
                                                                            <div class="col-md-1"></div>
                                                                            <label for="phone_no" class="col-md-3 col-form-label ml-sm-25 mr-sm-25 ml-xs-25 mr-xs-25 required">Phone No</label>
                                                                            <div class="col-md-7 ml-sm-25 mr-sm-25 ml-xs-25 mr-xs-25">
                                                                                <input type="text" name="phone_no" class="form-control" id="phone_no" value="{{$user->phone_no ? $user->phone_no : old('phone_no')}}" placeholder="Enter Phone Number" required>
                                                                            </div>
                                                                            <div class="col-md-1"></div>
                                                                        </div>

            {{--                                                            <div class="form-group row">--}}
            {{--                                                                <div class="col-md-1"></div>--}}
            {{--                                                                <label for="card_no" class="col-md-3 col-form-label ml-sm-25 mr-sm-25 ml-xs-25 mr-xs-25">Card Number</label>--}}
            {{--                                                                <div class="col-md-7 ml-sm-25 mr-sm-25 ml-xs-25 mr-xs-25">--}}
            {{--                                                                    <input type="text" name="card_no" class="form-control" id="card_no" value="{{$user->card_no ? $user->card_no : old('card_no')}}" placeholder="Enter Card Number">--}}
            {{--                                                                </div>--}}
            {{--                                                                <div class="col-md-1"></div>--}}
            {{--                                                            </div>--}}

                                                                        <div class="form-group row">
                                                                            <div class="col-md-1"></div>
                                                                            <label for="address" class="col-md-3 col-form-label ml-sm-25 mr-sm-25 ml-xs-25 mr-xs-25">Address</label>
                                                                            <div class="col-md-7 ml-sm-25 mr-sm-25 ml-xs-25 mr-xs-25">
                                                                                <input type="text" name="address" class="form-control" id="address" value="{{$user->address ? $user->address : old('address')}}" placeholder="Enter Address">
            {{--                                                                    <textarea name="address" class="form-control" id="address" value="" placeholder="Enter Address">{{$user->address ? $user->address : old('address')}}</textarea>--}}
                                                                            </div>
                                                                            <div class="col-md-1"></div>
                                                                        </div>

                                                                        <div class="form-group row">
                                                                            <div class="col-md-1"></div>
                                                                            <label for="city" class="col-md-3 col-form-label ml-sm-25 mr-sm-25 ml-xs-25 mr-xs-25">City</label>
                                                                            <div class="col-md-7 ml-sm-25 mr-sm-25 ml-xs-25 mr-xs-25">
                                                                                <input type="text" name="city" class="form-control" id="city" value="{{$user->city ? $user->city : old('city')}}" placeholder="Enter City">
                                                                            </div>
                                                                            <div class="col-md-1"></div>
                                                                        </div>

                                                                        <div class="form-group row">
                                                                            <div class="col-md-1"></div>
                                                                            <label for="country" class="col-md-3 col-form-label ml-sm-25 mr-sm-25 ml-xs-25 mr-xs-25">County</label>
                                                                            <div class="col-md-7 ml-sm-25 mr-sm-25 ml-xs-25 mr-xs-25">
                                                                                <input type="text" name="country" class="form-control" id="country" value="{{$user->country ? $user->country : old('country')}}" placeholder="Enter County">
                                                                            </div>
                                                                            <div class="col-md-1"></div>
                                                                        </div>

            {{--                                                            <div class="form-group row">--}}
            {{--                                                                <div class="col-md-1"></div>--}}
            {{--                                                                <label for="state" class="col-md-3 col-form-label ml-sm-25 mr-sm-25 ml-xs-25 mr-xs-25">State</label>--}}
            {{--                                                                <div class="col-md-7 ml-sm-25 mr-sm-25 ml-xs-25 mr-xs-25">--}}
            {{--                                                                    <input type="text" name="state" class="form-control" id="state" value="{{$user->state ? $user->country : old('state')}}" placeholder="Enter state">--}}
            {{--                                                                </div>--}}
            {{--                                                                <div class="col-md-1"></div>--}}
            {{--                                                            </div>--}}

                                                                        <div class="form-group row">
                                                                            <div class="col-md-1"></div>
                                                                            <label for="zip_code" class="col-md-3 col-form-label ml-sm-25 mr-sm-25 ml-xs-25 mr-xs-25">Post Code</label>
                                                                            <div class="col-md-7 ml-sm-25 mr-sm-25 ml-xs-25 mr-xs-25">
                                                                                <input type="text" name="zip_code" class="form-control" id="zip_code" value="{{$user->zip_code ? $user->zip_code : old('zip_code')}}" placeholder="Enter Post Code">
                                                                            </div>
                                                                            <div class="col-md-1"></div>
                                                                        </div>
                                                                        <input type="hidden" name="exist_image" value="{{$user->image}}">
                                                                        <div class="form-group row">
                                                                            <div class="col-md-12 text-center mb-5 mt-4">
                                                                                <button type="submit" class="btn btn-primary vendor-btn waves-effect waves-light">
                                                                                    <b>Update</b>
                                                                                </button>
                                                                            </div>
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                                <!--End Edit User Modal -->


                                                            @endif
                                                        </td>
                                                    </tr>
                                                <?php
                                                    }
                                                ?>

                                            </tbody>
                                            <!--End table body section-->

                                        </table>
                                        <!--End table section-->

                                    </div><!--table responsive-->

                                            <!--table below pagination sec-->
                                            <div class="row table-foo-sec">
                                                <div class="col-md-6 d-flex justify-content-md-start align-items-center">
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="d-flex justify-content-md-end align-items-center py-2">
                                                        <div class="pagination-area">
                                                            <div class="datatable-pages d-flex align-items-center">
                                                                <span class="displaying-num">{{$all_user->total()}} Users</span>
                                                                <span class="pagination-links d-flex">
                                                                    @if($all_user->currentPage() > 1)
                                                                    <a class="first-page btn {{$all_user->currentPage() > 1 ? '' : 'disable'}}" href="{{$all_decode_user->first_page_url}}" data-toggle="tooltip" data-placement="top" title="First Page">
                                                                        <span class="screen-reader-text d-none">First page</span>
                                                                        <span aria-hidden="true">«</span>
                                                                    </a>
                                                                    <a class="prev-page btn {{$all_user->currentPage() > 1 ? '' : 'disable'}}" href="{{$all_decode_user->prev_page_url}}" data-toggle="tooltip" data-placement="top" title="Previous Page">
                                                                        <span class="screen-reader-text d-none">Previous page</span>
                                                                        <span aria-hidden="true">‹</span>
                                                                    </a>
                                                                    @endif
                                                                    <span class="screen-reader-text" style="display: none;">Current Page</span>
                                                                    <span class="paging-input d-flex align-items-center">
                                                                        <span class="datatable-paging-text d-flex pl-1"> {{$all_decode_user->current_page}} of <span class="total-pages">{{$all_decode_user->last_page}}</span></span>
                                                                    </span>
                                                                    @if($all_user->currentPage() !== $all_user->lastPage())
                                                                    <a class="next-page btn" href="{{$all_decode_user->next_page_url}}" data-toggle="tooltip" data-placement="top" title="Next Page">
                                                                        <span class="screen-reader-text d-none">Next page</span>
                                                                        <span aria-hidden="true">›</span>
                                                                    </a>
                                                                    <a class="last-page btn" href="{{$all_decode_user->last_page_url}}" data-toggle="tooltip" data-placement="top" title="Last Page">
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

                                    </div> <!-- User list tab-->

                                    <div id="role_list" class="tab-pane m-b-20"><br>
                                        <div class="row">
                                            <div class="col-md-8 offset-md-2">
                                                <div class="card role-card m-t-20 m-b-20">

                                                    @if ($errors->any())
                                                        <div class="alert alert-danger">
                                                            <ul>
                                                                @foreach ($errors->all() as $error)
                                                                    <li>{{ $error }}</li>
                                                                @endforeach
                                                            </ul>
                                                        </div>
                                                    @endif

                                                    @if (Session::has('role_add_success_msg'))
                                                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                                                            {!! Session::get('role_add_success_msg') !!}
                                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                    @endif

                                                    @if (Session::has('role_updated_success_msg'))
                                                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                                                            {!! Session::get('role_updated_success_msg') !!}
                                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                    @endif

                                                    @if (Session::has('role_delete_success_msg'))
                                                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                                            {!! Session::get('role_delete_success_msg') !!}
                                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                    @endif


                                                    <div class="card-header role-header d-flex justify-content-start">
                                                        <div class="w-50">
                                                            Role Name
                                                        </div>
                                                        <div class="w-50">
                                                            Actions
                                                        </div>
                                                    </div>
                                                    @isset($all_role)
                                                        @foreach($all_role as $role)
                                                    <ul class="list-group list-group-flush">
                                                        <li class="list-group-item d-flex justify-content-start">
                                                            <div class="w-50 d-flex align-items-center">{{$role->role_name}}</div>
                                                            <div class="w-50">
                                                                <div class="d-flex justify-content-start align-items-center">
                                                                    {{--                                                    <a href="{{url('role/'.$role->id.'/edit')}}" ><button class="vendor_btn_edit btn-primary">Edit</button></a>&nbsp;--}}
                                                                    <a class="btn-size edit-btn mr-2" href="#editRoleList{{$role->id}}" data-animation="slit" data-plugin="custommodal"
                                                                    data-overlaySpeed="100" data-overlayColor="#36404a" data-placement="top" title="Edit"><i class="fa fa-edit" aria-hidden="true"></i></a>
            {{--                                                        <a href="{{url('role/'.$role->id)}}" ><button class="vendor_btn_view btn-success">View</button></a>&nbsp;--}}
                                                                    <form action="{{url('role/'.$role->id)}}" method="post">
                                                                        @method('DELETE')
                                                                        @csrf
            {{--                                                            <a href="#" class="on-default remove-row" ><button class="vendor_btn_delete btn-danger" onclick="return check_delete('role');">Delete</button>  </a>--}}
                                                                        <button style="cursor: pointer" type="submit" class="btn-size delete-btn on-default remove-row" onclick="return check_delete('role');" data-toggle="tooltip"  data-placement="top" title="Delete"><i class="fa fa-trash" aria-hidden="true"></i></button>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </li>
                                                    </ul>

                                                    <!-- Edit Role Modal -->
                                                    <div id="editRoleList{{$role->id}}" class="modal-demo">
                                                        <button type="button" class="close" onclick="Custombox.close();">
                                                            <span>&times;</span><span class="sr-only">Close</span>
                                                        </button>
                                                        <h4 class="custom-modal-title">Change Brand Name</h4>
                                                        <form role="form" class="vendor-form mobile-responsive" action="{{url('role/'.$role->id)}}" method="post">
                                                            @method('PUT')
                                                            @csrf
                                                            <div class="form-group row">
                                                                <div class="col-md-1"></div>
                                                                <label for="name" class="col-md-2 col-form-label ml-sm-25 mr-sm-25 ml-xs-25 mr-xs-25 required">Brand Name</label>
                                                                <div class="col-md-8 ml-sm-25 mr-sm-25 ml-xs-25 mr-xs-25">
                                                                    <input type="text" name="role_name" class="form-control" id="role_name" value="{{ $role->role_name ? $role->role_name : old('role_name') }}" placeholder="Enter role name" required>
                                                                </div>
                                                                <div class="col-md-1"></div>
                                                            </div>

                                                            <div class="form-group row">
                                                                <div class="col-md-12 text-center mb-5 mt-3">
                                                                    <button type="submit" class="btn btn-primary vendor-btn waves-effect waves-light">
                                                                        <b>Update</b>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                    <!--End Edit Role Modal -->


                                                        @endforeach
                                                    @endisset

                                                </div> <!--// End card-->
                                            </div><!--col-md-8-->
                                        </div><!--row-->


                                    </div>

                                </div> <!-- Tab container content -->



                                <!--Add User Modal -->
                                <div id="addUser" class="modal-demo">
                                    <button type="button" class="close" onclick="Custombox.close();">
                                        <span>&times;</span><span class="sr-only">Close</span>
                                    </button>
                                    <h4 class="custom-modal-title">Add User</h4>
                                    <form role="form" class="vendor-form mobile-responsive" action="{{url('save-user')}}" method="post" enctype="multipart/form-data" data-parsley-validate>
                                        @csrf
                                        <div class="form-group row">
                                            <div class="col-md-1"></div>
                                            <label for="first_name" class="col-md-3 col-form-label ml-sm-25 mr-sm-25 ml-xs-25 mr-xs-25 required">First Name</label>
                                            <div class="col-md-7 ml-sm-25 mr-sm-25 ml-xs-25 mr-xs-25">
                                                {{-- <input type="text" name="name" value="{{old('name')}}" class="form-control" id="name" placeholder="Enter First Name" data-parsley-maxlength="30" data-parsley-pattern="^[a-zA-Z]+$" data-parsley-trigger="keyup" required> --}}
                                                <input type="text" name="name" value="{{old('name')}}" class="form-control" id="name" placeholder="Enter First Name" data-parsley-maxlength="30" required>
                                            </div>
                                            <div class="col-md-1"></div>
                                        </div>

                                        <div class="form-group row">
                                            <div class="col-md-1"></div>
                                            <label for="last_name" class="col-md-3 col-form-label ml-sm-25 mr-sm-25 ml-xs-25 mr-xs-25 required">Last Name</label>
                                            <div class="col-md-7 ml-sm-25 mr-sm-25 ml-xs-25 mr-xs-25">
                                                <input type="text" name="last_name" value="{{old('last_name')}}" class="form-control" id="last_name" placeholder="Enter Last Name" data-parsley-maxlength="30" required>
                                            </div>
                                            <div class="col-md-1"></div>
                                        </div>

                                        {{-- <div class="form-group row">
                                            <div class="col-md-1"></div>
                                            <label for="employee_id" class="col-md-3 col-form-label ml-sm-25 mr-sm-25 ml-xs-25 mr-xs-25">Employee ID</label>
                                            <div class="col-md-7 ml-sm-25 mr-sm-25 ml-xs-25 mr-xs-25">
                                                <input type="text" name="employee_id" data-parsley-maxlength="30" value="{{old('employee_id')}}" class="form-control" id="employee_id" placeholder="Enter Employee ID">
                                            </div>
                                            <div class="col-md-1"></div>
                                        </div> --}}

                                        <div class="form-group row">
                                            <div class="col-md-1"></div>
                                            <label for="email" class="col-md-3 col-form-label ml-sm-25 mr-sm-25 ml-xs-25 mr-xs-25 required">Email Address</label>
                                            <div class="col-md-7 ml-sm-25 mr-sm-25 ml-xs-25 mr-xs-25">
                                                <input type="email" name="email" value="{{old('email')}}" class="form-control" id="email" placeholder="Enter Email" data-parsley-type="email" required>
                                            </div>
                                            <div class="col-md-1"></div>
                                        </div>

                                        <div class="form-group row">
                                            <div class="col-md-1"></div>
                                            <label for="password" class="col-md-3 col-form-label ml-sm-25 mr-sm-25 ml-xs-25 mr-xs-25 required">Password</label>
                                            <div class="col-md-7 ml-sm-25 mr-sm-25 ml-xs-25 mr-xs-25">
                                                <input type="password" name="password" class="form-control" id="password" placeholder="Enter Password" data-parsley-minlength="8" data-parsley-minlength-message="Password must be at least 8 characters" data-parsley-required />
                                            </div>
                                            <div class="col-md-1"></div>
                                        </div>

                                        <div class="form-group row">
                                            <div class="col-md-1"></div>
                                            <label for="password_confirmation" class="col-md-3 col-form-label ml-sm-25 mr-sm-25 ml-xs-25 mr-xs-25 required">Confirm Password</label>
                                            <div class="col-md-7 ml-sm-25 mr-sm-25 ml-xs-25 mr-xs-25">
                                                <input type="password" name="password_confirmation"  class="form-control" id="password_confirmation" placeholder="Enter Confirm Password" data-parsley-equalto="#password" data-parsley-required />
                                            </div>
                                            <div class="col-md-1"></div>
                                        </div>

                                        <div class="form-group row">
                                            <div class="col-md-1"></div>
                                            <label for="role" class="col-md-3 col-form-label ml-sm-25 mr-sm-25 ml-xs-25 mr-xs-25 required">Role</label>
                                            <div class="col-md-7 ml-sm-25 mr-sm-25 ml-xs-25 mr-xs-25">
                                                <div class="wms-row user-row">
                                                    @isset($all_role)
                                                        @foreach($all_role as $role)
                                                            <div class="wms-col-4 user-checkbox">
                                                                <input type="checkbox" name="role[]" value="{{$role->id}}" data-parsley-multiple="mymultiplelink" required>&nbsp;{{$role->role_name}}
                                                            </div>
                                                        @endforeach
                                                    @endisset
                                                </div>
                                            </div>
                                            <div class="col-md-1"></div>
                                        </div>

                                        <div class="form-group row">
                                            <div class="col-md-1"></div>
                                            <label for="phone_no" class="col-md-3 col-form-label ml-sm-25 mr-sm-25 ml-xs-25 mr-xs-25 required">Phone No</label>
                                            <div class="col-md-7 ml-sm-25 mr-sm-25 ml-xs-25 mr-xs-25">
                                                <input type="number" name="phone_no" data-parsley-maxlength="30" value="{{old('phone_no')}}" class="form-control" id="phone_no" placeholder="Enter Phone Number" required>
                                            </div>
                                            <div class="col-md-1"></div>
                                        </div>

                            {{--            <div class="form-group row">--}}
                            {{--                <div class="col-md-1"></div>--}}
                            {{--                <label for="card_no" class="col-md-3 col-form-label ml-sm-25 mr-sm-25 ml-xs-25 mr-xs-25">Card Number</label>--}}
                            {{--                <div class="col-md-7 ml-sm-25 mr-sm-25 ml-xs-25 mr-xs-25">--}}
                            {{--                    <input type="text" name="card_no" data-parsley-maxlength="30" value="{{old('card_no')}}" class="form-control" id="card_no" placeholder="Card number">--}}
                            {{--                </div>--}}
                            {{--                <div class="col-md-1"></div>--}}
                            {{--            </div>--}}

                                        <div class="form-group row">
                                            <div class="col-md-1"></div>
                                            <label for="image" class="col-md-3 col-form-label ml-sm-25 mr-sm-25 ml-xs-25 mr-xs-25">Select Image</label>
                                            <div class="col-md-7 ml-sm-25 mr-sm-25 ml-xs-25 mr-xs-25">
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input" id="imgInp_add" name="user_image">
                                                    <label class="custom-file-label" for="customFile">Choose Image</label>
                                                </div>
                                                <img id="blah_add" class="rounded mt-2 float-left" src="#" alt="Images" width="150px" height="120px" style="display: none;">
                                            </div>
                                            <div class="col-md-1"></div>
                                        </div>

                                        <div class="form-group row">
                                            <div class="col-md-1"></div>
                                            <label for="address" class="col-md-3 col-form-label ml-sm-25 mr-sm-25 ml-xs-25 mr-xs-25">Address</label>
                                            <div class="col-md-7 ml-sm-25 mr-sm-25 ml-xs-25 mr-xs-25">
                                                <input type="text" class="form-control" name="address" id="address" placeholder="Enter Address" value="{{old('address')}}">
                            {{--                    <textarea class="form-control" name="address" id="address" data-parsley-minlength="10" data-parsley-maxlength="100" placeholder="Type Your Address"></textarea>--}}
                                            </div>
                                            <div class="col-md-1"></div>
                                        </div>

                                        <div class="form-group row">
                                            <div class="col-md-1"></div>
                                            <label for="city" class="col-md-3 col-form-label ml-sm-25 mr-sm-25 ml-xs-25 mr-xs-25">City</label>
                                            <div class="col-md-7 ml-sm-25 mr-sm-25 ml-xs-25 mr-xs-25">
                                                <input type="text" name="city"  class="form-control" value="{{old('city')}}" id="city" placeholder="Enter City">
                                            </div>
                                            <div class="col-md-1"></div>
                                        </div>

                                        <div class="form-group row">
                                            <div class="col-md-1"></div>
                                            <label for="country" class="col-md-3 col-form-label ml-sm-25 mr-sm-25 ml-xs-25 mr-xs-25">County</label>
                                            <div class="col-md-7 ml-sm-25 mr-sm-25 ml-xs-25 mr-xs-25">
                                                <input type="text" name="country"  class="form-control" value="{{old('country')}}" id="country" placeholder="Enter County">
                                            </div>
                                            <div class="col-md-1"></div>
                                        </div>

                            {{--            <div class="form-group row">--}}
                            {{--                <div class="col-md-1"></div>--}}
                            {{--                <label for="state" class="col-md-3 col-form-label ml-sm-25 mr-sm-25 ml-xs-25 mr-xs-25">State</label>--}}
                            {{--                <div class="col-md-7 ml-sm-25 mr-sm-25 ml-xs-25 mr-xs-25">--}}
                            {{--                    <input type="text" name="state" class="form-control" value="{{old('state')}}" id="state" placeholder="State">--}}
                            {{--                </div>--}}
                            {{--                <div class="col-md-1"></div>--}}
                            {{--            </div>--}}

                                        <div class="form-group row">
                                            <div class="col-md-1"></div>
                                            <label for="zip_code" class="col-md-3 col-form-label ml-sm-25 mr-sm-25 ml-xs-25 mr-xs-25">Post Code</label>
                                            <div class="col-md-7 ml-sm-25 mr-sm-25 ml-xs-25 mr-xs-25">
                                                <input type="text" name="zip_code"  class="form-control" value="{{old('zip_code')}}" id="zip_code" placeholder="Enter Post Code">
                                            </div>
                                            <div class="col-md-1"></div>
                                        </div>


                                        <div class="form-group row">
                                            <div class="col-md-12 text-center mb-5 mt-4">
                                                <button type="submit" class="btn btn-primary vendor-btn waves-effect waves-light">
                                                    <b>Submit</b>
                                                </button>
                                            </div>
                                        </div>

                                    </form>
                                </div><!--End User Modal -->



                            </div>  <!--Shelf wise -->
                        </div> <!-- Col-md-12 -->
                    </div> <!-- Row -->
                </div> <!-- Container fluid -->
            </div> <!--Content-->


    <!--Add Role Modal -->
    <div id="addRole" class="modal-demo">
        <button type="button" class="close" onclick="Custombox.close();">
            <span>&times;</span><span class="sr-only">Close</span>
        </button>
        <h4 class="custom-modal-title">Add Role</h4>
        {{--                                <div class="modal-body">--}}

        <form role="form" class="vendor-form mobile-responsive" action="{{url('role')}}" method="post">
            @csrf
            <div class="form-group row">
                <div class="col-md-1"></div>
                <label for="name" class="col-md-2 col-form-label ml-sm-25 mr-sm-25 ml-xs-25 mr-xs-25 required">Role Name</label>
                <div class="col-md-8 ml-sm-25 mr-sm-25 ml-xs-25 mr-xs-25">
                    <input type="text" name="role_name" class="form-control" id="role_name" value="{{ old('role_name') }}" placeholder="Enter Role Name" required>
                </div>
                <div class="col-md-1"></div>
            </div>

            <div class="form-group row">
                <div class="col-md-12 text-center mb-5 mt-3">
                    <button type="submit" class="btn btn-primary vendor-btn waves-effect waves-light">
                        <b>Submit</b>
                    </button>
                </div>
            </div>
        </form>
    </div>
    <!-- End Role Modal -->



    <script>

        // Image show Jquery
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    $('img#blah').attr('src', e.target.result);
                    $('#blah_add').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        $("#imgInp").change(function() {
            $('img#user_edit_image').hide();
            $('img#blah').show();
            readURL(this);
        });

        $("#imgInp_add").change(function() {
            $('#blah_add').show();
            readURL(this);
        });



        //Datatable row-wise searchable option
        $(document).ready(function(){
            $("#row-wise-search").on("keyup", function() {
                let value = $(this).val().toLowerCase();
                $("#table-body tr").filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });

            });
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

        //prevent onclick dropdown menu close
        $('.filter-content').on('click', function(event){
            event.stopPropagation();
        });


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

    </script>



@endsection
