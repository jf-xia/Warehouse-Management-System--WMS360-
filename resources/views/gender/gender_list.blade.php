@extends('master')

@section('title')
    Department | WMS360
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

                <div class="wms-breadcrumb">
                    <ol class="breadcrumb page-breadcrumb">
                        <li class="breadcrumb-item"> Wms Category </li>
                        <li class="breadcrumb-item active" aria-current="page"> Department </li>
                    </ol>
                    <div class="breadcrumbRightSideBtn">
                        <a href="#addDepartment" data-animation="slit" data-plugin="custommodal" data-overlaySpeed="100" data-overlayColor="#36404a"><button class="btn btn-default waves-effect waves-light">Add Department</button></a>
                    </div>
                </div>


                <div class="row m-t-20">
                    <div class="col-md-12">
                        <div class="card-box table-responsive shadow">

                            @if (Session::has('gender_delete_success_msg'))
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    {!! Session::get('gender_delete_success_msg') !!}
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif
                            @if (Session::has('gender_edit_success_msg'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    {!! Session::get('gender_edit_success_msg') !!}
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif

                            @if (Session::has('gender_create_success_msg'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    {!! Session::get('gender_create_success_msg') !!}
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif



                            <table id="" class="gender-list-table w-100">
                                <thead>
                                <tr>
                                    <th class="text-center w-50">Department Name</th>
                                    <th class="text-center w-50">Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                @isset($all_genders)
                                    @foreach($all_genders as $gender)
                                        <tr>
                                            <td class="text-center w-50">{{$gender->name}}</td>
                                            <td class="w-50">
                                                <div class="d-flex justify-content-center">
                                                    {{--                                                <a href="{{url('gender/'.$gender->id.'/edit')}}" ><button class="vendor_btn_edit btn-primary">Edit</button></a>&nbsp;--}}
                                                    <a class="btn-size edit-btn mr-2" href="#editBrandList{{$gender->id}}" data-animation="slit" data-plugin="custommodal"
                                                       data-overlaySpeed="100" data-overlayColor="#36404a" data-placement="top" title="Edit"><i class="fa fa-edit" aria-hidden="true"></i></a>&nbsp;
                                                    {{--                                                <a href="{{url('category/'.$gender->id)}}" ><button class="vendor_btn_view btn-success">View</button></a>&nbsp;--}}
                                                    <form action="{{url('gender/'.$gender->id)}}" method="post">
                                                        @method('DELETE')
                                                        @csrf
                                                        <button style="cursor: pointer" type="submit" class="btn-size delete-btn on-default remove-row" onclick="return check_delete('gender');" data-toggle="tooltip"  data-placement="top" title="Delete"><i class="fa fa-trash" aria-hidden="true"></i></button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>

                                        <!-- Edit Btn Modal -->
                                        <div id="editBrandList{{$gender->id}}" class="modal-demo">
                                            <button type="button" class="close" onclick="Custombox.close();">
                                                <span>&times;</span><span class="sr-only">Close</span>
                                            </button>
                                            <h4 class="custom-modal-title">Edit Department Name</h4>
                                            <form role="form" class="vendor-form mobile-responsive" action="{{url('gender/'.$gender->id)}}" method="post">
                                                @method('PUT')
                                                @csrf
                                                <div class="form-group row">
                                                    <div class="col-md-1"></div>
                                                    <label for="name" class="col-md-3 col-form-label ml-sm-25 mr-sm-25 ml-xs-25 mr-xs-25 required">Department Name</label>
                                                    <div class="col-md-7 ml-sm-25 mr-sm-25 ml-xs-25 mr-xs-25">
                                                        <input type="text" name="name" class="form-control" id="name" value="{{ $gender->name ? $gender->name :old('name') }}" placeholder="Enter Department Name" required>
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
                                        <!--End Edit Btn Modal -->



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




    <!-- Modal -->
    <div id="addDepartment" class="modal-demo">
        <button type="button" class="close" onclick="Custombox.close();">
            <span>&times;</span><span class="sr-only">Close</span>
        </button>
        <h4 class="custom-modal-title">Add Department</h4>
        <form role="form" class="vendor-form mobile-responsive" action="{{url('gender')}}" method="post">
            @csrf
            <div class="form-group row">
                <div class="col-md-1"></div>
                <label for="name" class="col-md-3 col-form-label ml-sm-25 mr-sm-25 ml-xs-25 mr-xs-25 required">Department Name</label>
                <div  class="col-md-7 ml-sm-25 mr-sm-25 ml-xs-25 mr-xs-25">
                    <input type="text" name="name" class="form-control" id="name" value="{{ old('gender') }}" placeholder="Enter Department Name" required>
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
    <!-- Modal -->




    @endsection
