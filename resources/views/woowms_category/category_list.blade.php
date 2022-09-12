@extends('master')

@section('title')
    Category List | WMS360
@endsection

@section('content')


    <link href="{{asset('assets/css/select2.min.css')}}" rel="stylesheet" type="text/css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>

    <!-- Custombox -->
    <link href="{{asset('assets/plugins/custombox/css/custombox.css')}}" rel="stylesheet">

    <!-- Modal-Effect -->
    <script src="{{asset('assets/plugins/custombox/js/custombox.min.js')}}"></script>
    <script src="{{asset('assets/plugins/custombox/js/legacy.min.js')}}"></script>



    <div class="content-page">
        <!-- Start content -->
        <div class="content">
            <div class="container-fluid">

                <div class="wms-breadcrumb">
                    <ol class="breadcrumb page-breadcrumb">
                        <li class="breadcrumb-item">Wms Category</li>
                        <li class="breadcrumb-item active" aria-current="page"> Category List </li>
                    </ol>

                    <div class="breadcrumbRightSideBtn mt-xs-15">
                        <a href="#addWmsCategory" data-animation="slit" data-plugin="custommodal" data-overlaySpeed="100" data-overlayColor="#36404a"><button class="btn btn-default">Add Category</button></a>&nbsp;
                    </div>
                </div>


                <div class="row m-t-20">
                    <div class="col-md-12">
                        <div class="card-box table-responsive shadow">

                            @if (Session::has('error'))
                                <div  class="alert alert-danger alert-dismissible fade show" role="alert">
                                    {!! Session::get('error') !!}
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif


                            @if (Session::has('success'))
                                <div  class="alert alert-success alert-dismissible fade show" role="alert">
                                    {!! Session::get('success') !!}
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif


                            @if (Session::has('wms_category_update_success_msg'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    {!! Session::get('wms_category_update_success_msg') !!}
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif

                            @if (Session::has('wms_category_delete_success_msg'))
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    {!! Session::get('wms_category_delete_success_msg') !!}
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif


                            <table id="datatable" class="brand-list-table w-100">
                                <thead>
                                <tr>
                                    <th style="width: 25%">Category Name</th>
                                    <th style="width: 15%">Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                @isset($all_woowms_categories)
                                    @foreach($all_woowms_categories as $categories)
                                        <tr>
                                            <td style="width: 25%">{{$categories->category_name}}</td>
                                            <td style="width: 15%">

                                                <div class="d-flex align-items-center">
                                                    <a href="{{url('woowms-category/'.$categories->id.'/edit')}}" target="_blank"><button class="btn-size edit-btn mr-2" style="cursor: pointer"><i class="fa fa-edit" aria-hidden="true"></i></button></a>
{{--                                                    <button type="button" class="btn-size edit-btn mr-2" style="cursor: pointer" data-toggle="modal" data-target="#editWmsCategory">--}}
{{--                                                        <i class="fa fa-edit" aria-hidden="true"></i>--}}
{{--                                                    </button>--}}
{{--                                                    <a href="#editWmsCategory{{$categories->id}}" data-animation="slit" data-plugin="custommodal" data-overlaySpeed="100" data-overlayColor="#36404a"><button class="btn-size edit-btn mr-2" style="cursor: pointer"><i class="fa fa-edit" aria-hidden="true"></i></button></a>--}}
                                                    <form action="{{url('woowms-category/'.$categories->id)}}" method="post">
                                                        @method('DELETE')
                                                        @csrf
                                                        <a href="#" class="on-default remove-row" ><button class="btn-size delete-btn" onclick="return check_delete('Woo Wms Category');" style="cursor: pointer"><i class="fa fa-trash" aria-hidden="true"></i></button>  </a>
                                                    </form>
                                                </div>


                                                <!--Edit Wms Category Modal -->
{{--                                                <div id="editWmsCategory{{$categories->id}}" class="modal-demo">--}}
{{--                                                    <button type="button" class="close" onclick="Custombox.close();">--}}
{{--                                                        <span>&times;</span><span class="sr-only">Close</span>--}}
{{--                                                    </button>--}}
{{--                                                    <h4 class="custom-modal-title">Edit Category Name</h4>--}}
{{--                                                    <form role="form" class="vendor-form mobile-responsive" action="{{url('woowms-category/'.$categories->id)}}" method="post">--}}
{{--                                                        @method('PUT')--}}
{{--                                                        @csrf--}}
{{--                                                        <div class="form-group row">--}}
{{--                                                            <div class="col-md-1"></div>--}}
{{--                                                            <label for="gender" class="col-md-3 col-form-label required">Department</label>--}}
{{--                                                            <div class="col-md-7 ml-sm-10 mr-sm-10 ml-xs-10 mr-xs-10 wow pulse">--}}

{{--                                                                <select class="form-control select2" name="gender_id[]" multiple="multiple">--}}
{{--                                                                    @if(count($genders) > 0)--}}
{{--                                                                        @foreach($genders as $gender)--}}
{{--                                                                            @foreach($categories->genders as $single_user)--}}
{{--                                                                                @if($gender->id == $single_user->id)--}}
{{--                                                                                    <option value="{{$gender->id}}" selected>{{$gender->name}}</option>--}}
{{--                                                                                @endif--}}
{{--                                                                            @endforeach--}}
{{--                                                                            @if($temp == null)--}}
{{--                                                                                <option value="{{$gender->id}}">{{$gender->name}}</option>--}}
{{--                                                                            @endif--}}
{{--                                                                        @endforeach--}}
{{--                                                                    @endisset--}}
{{--                                                                </select>--}}

{{--                                                            </div>--}}
{{--                                                            <div class="col-md-1"></div>--}}
{{--                                                        </div>--}}

{{--                                                        <div class="form-group row">--}}
{{--                                                            <div class="col-md-1"></div>--}}
{{--                                                            <label for="category_name" class="col-md-3 col-form-label required">Category Name</label>--}}
{{--                                                            <div class="col-md-7 ml-sm-10 mr-sm-10 ml-xs-10 mr-xs-10 wow pulse">--}}
{{--                                                                <input type="text" name="category_name" class="form-control" id="category_name" value="{{ $categories->category_name ?? old('category_name') }}" placeholder="Enter Woo Wms Category name" required>--}}
{{--                                                            </div>--}}
{{--                                                            <div class="col-md-1"></div>--}}
{{--                                                        </div>--}}

{{--                                                        <div class="form-group row">--}}
{{--                                                            <div class="col-md-12 text-center mb-5 mt-4">--}}
{{--                                                                <button type="submit" class="btn btn-primary vendor-btn waves-effect waves-light">--}}
{{--                                                                    <b>Update</b>--}}
{{--                                                                </button>--}}
{{--                                                            </div>--}}
{{--                                                        </div>--}}

{{--                                                    </form>--}}
{{--                                                </div>--}}
                                                <!--End Edit Wms Category Modal -->


                                            </td>
                                        </tr>
                                    @endforeach
                                @endisset
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div> <!-- end row -->
            </div> <!-- container -->
        </div> <!-- content -->
    </div>



    <!-- Add WMS Category Modal -->
    <div id="addWmsCategory" class="modal-demo">
        <button type="button" class="close" onclick="Custombox.close();">
            <span>&times;</span><span class="sr-only">Close</span>
        </button>
        <h4 class="custom-modal-title">Add Category</h4>
        <form role="form" class="vendor-form mobile-responsive" action="{{url('woowms-category')}}" method="post">
            @csrf
            <div class="form-group row">
                <div class="col-md-1"></div>
                <label for="name" class="col-md-3 col-form-label ml-sm-25 mr-sm-25 ml-xs-25 mr-xs-25 required">Department</label>
                <div class="col-md-7 ml-sm-25 mr-sm-25 ml-xs-25 mr-xs-25">
{{--                    <select class="form-control select2" name="gender_id[]" id="gender_id" multiple="multiple">--}}
                    <select class="form-control select2" name="gender_id[]" multiple="multiple">
                        @isset($genders)
                            @foreach($genders as $gender)
                                <option value="{{$gender->id}}">{{$gender->name}}</option>
                            @endforeach
                        @endisset
                    </select>
                </div>
                <div class="col-md-1"></div>
            </div>
            <div class="form-group row">
                <div class="col-md-1"></div>
                <label for="name" class="col-md-3 col-form-label ml-sm-25 mr-sm-25 ml-xs-25 mr-xs-25 required">Category Name</label>
                <div class="col-md-7 ml-sm-25 mr-sm-25 ml-xs-25 mr-xs-25">
                    <input type="text" name="category_name" class="form-control" id="category_name" value="{{ old('category_name') }}" placeholder="Enter category name" required>
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
    <!--End Add WMS Category Modal-->


    <script>
        $('.select2').select2({
            placeholder: "Select department",
            allowClear: true
        });
    </script>


@endsection
