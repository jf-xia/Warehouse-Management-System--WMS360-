@extends('master')

@section('title')
    Role List | WMS360
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

                <div class="d-flex justify-content-between align-items-center">
                    <ol class="breadcrumb page-breadcrumb">
{{--                        <li class="breadcrumb-item"> Role </li>--}}
                        <li class="breadcrumb-item active" aria-current="page"> Role List </li>
                    </ol>
                    <div>
                        <a href="#addRole" data-animation="slit" data-plugin="custommodal" data-overlaySpeed="100" data-overlayColor="#36404a"><button class="btn btn-default">Add Role</button></a>&nbsp;
                    </div>
                </div>

                <!-- Page-Title -->
{{--                <div class="row">--}}
{{--                    <div class="col-md-12 text-center">--}}
{{--                        <div class="vendor-title">--}}
{{--                            <p>Role List</p>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
                <!--// End Page-Title -->

                <!-- Role list content start--->
                <div class="row m-t-20">
                    <div class="col-md-12">
                        <div class="card-box shadow">


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




                            <div class="row">
                                <div class="col-md-8 offset-md-2">
                                    <div class="card role-card m-t-20 m-b-20">
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
                                </div>
                            </div>

{{--                            <table id="datatable" class="table table-bordered">--}}
{{--                                <thead>--}}
{{--                                <tr>--}}
{{--                                    <th>Role Name</th>--}}
{{--                                    <th>Actions</th>--}}
{{--                                </tr>--}}
{{--                                </thead>--}}
{{--                                <tbody>--}}
{{--                                @isset($all_role)--}}
{{--                                    @foreach($all_role as $role)--}}
{{--                                        <tr>--}}
{{--                                            <td>{{$role->role_name}}</td>--}}
{{--                                            <td class="actions form_action">--}}
{{--                                                <a href="{{url('role/'.$role->id.'/edit')}}" ><button class="vendor_btn_edit btn-primary">Edit</button></a>&nbsp;--}}
{{--                                                <a href="{{url('role/'.$role->id)}}" ><button class="vendor_btn_view btn-success">View</button></a>&nbsp;--}}
{{--                                                <form action="{{url('role/'.$role->id)}}" method="post">--}}
{{--                                                    @method('DELETE')--}}
{{--                                                    @csrf--}}
{{--                                                    <a href="#" class="on-default remove-row" ><button class="vendor_btn_delete btn-danger" onclick="return check_delete('role');">Delete</button>  </a>--}}
{{--                                                </form>--}}
{{--                                            </td>--}}
{{--                                        </tr>--}}
{{--                                    @endforeach--}}
{{--                                @endisset--}}
{{--                                </tbody>--}}
{{--                            </table>--}}
                        </div>
                    </div>
                </div> <!--// End Role list content start--->
            </div> <!-- container -->
        </div> <!-- content -->
    </div>

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


@endsection
