@extends('master')

@section('title')
    Brand | WMS360
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
                        <li class="breadcrumb-item">Wms Category</li>
                        <li class="breadcrumb-item active" aria-current="page"> Brand </li>
                    </ol>

                    <div class="breadcrumbRightSideBtn">
                        <a href="#addBrand" data-animation="slit" data-plugin="custommodal" data-overlaySpeed="100" data-overlayColor="#36404a"><button class="btn btn-default">Add Brand</button></a>&nbsp;
                    </div>
                </div>


                <div class="row m-t-20">
                    <div class="col-md-12">
                        <div class="card-box table-responsive shadow">

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

                            @if (Session::has('brand_delete_success_msg'))
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    {!! Session::get('brand_delete_success_msg') !!}
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif
                            @if (Session::has('brand_edit_success_msg'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    {!! Session::get('brand_edit_success_msg') !!}
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif

                            @if (Session::has('brand_create_success_msg'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    {!! Session::get('brand_create_success_msg') !!}
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif


                            <table class="brand-list-table w-100">
                                <thead>
                                <tr>
                                    <th class="text-center w-50">Brand Name</th>
                                    <th class="text-center w-50">Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                @isset($all_brands)
                                    @foreach($all_brands as $brand)
                                        <tr>
                                            <td class="text-center w-50">{{$brand->name}}</td>
                                            <td class="w-50">
                                                <div class="d-flex justify-content-center">
                                                    {{--                                                <a href="{{url('brand/'.$brand->id.'/edit')}}" ><button class="vendor_btn_edit btn-primary">Edit</button></a>&nbsp;--}}
                                                    <a class="btn-size edit-btn mr-2" href="#editBrandList{{$brand->id}}" data-animation="slit" data-plugin="custommodal"
                                                       data-overlaySpeed="100" data-overlayColor="#36404a" data-placement="top" title="Edit"><i class="fa fa-edit" aria-hidden="true"></i></a>&nbsp;
                                                    {{--                                                <a href="{{url('category/'.$brand->id)}}" ><button class="vendor_btn_view btn-success">View</button></a>&nbsp;--}}
                                                    <form action="{{url('brand/'.$brand->id)}}" method="post">
                                                        @method('DELETE')
                                                        @csrf
                                                        <button style="cursor: pointer" type="submit" class="btn-size delete-btn on-default remove-row" onclick="return check_delete('brand');" data-toggle="tooltip"  data-placement="top" title="Delete"><i class="fa fa-trash" aria-hidden="true"></i></button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>




                                        <!-- Edit Btn Modal -->
                                        <div id="editBrandList{{$brand->id}}" class="modal-demo">
                                            <button type="button" class="close" onclick="Custombox.close();">
                                                <span>&times;</span><span class="sr-only">Close</span>
                                            </button>
                                            <h4 class="custom-modal-title">Edit Brand Name</h4>
                                            <form role="form" class="vendor-form mobile-responsive" action="{{url('brand/'.$brand->id)}}" method="post">
                                                @method('PUT')
                                                @csrf
                                                <div class="form-group row">
                                                    <div class="col-md-1"></div>
                                                    <label for="name" class="col-md-3 col-form-label ml-sm-25 mr-sm-25 ml-xs-25 mr-xs-25 required">Brand Name</label>
                                                    <div class="col-md-7 ml-sm-25 mr-sm-25 ml-xs-25 mr-xs-25">
                                                        <input type="text" name="name" class="form-control" id="name" value="{{ $brand->name ? $brand->name :old('name') }}" placeholder="Enter brand name" required>
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



    <!--Add Brand Modal -->
    <div id="addBrand" class="modal-demo">
        <button type="button" class="close" onclick="Custombox.close();">
            <span>&times;</span><span class="sr-only">Close</span>
        </button>
        <h4 class="custom-modal-title">Add Brand</h4>
        <form role="form" class="vendor-form mobile-responsive" action="{{url('brand')}}" method="post">
            @csrf
            <div class="form-group row">
                <div class="col-md-1"></div>
                <label for="name" class="col-md-3 col-form-label ml-sm-25 mr-sm-25 ml-xs-25 mr-xs-25 required">Brand Name</label>
                <div class="col-md-7 ml-sm-25 mr-sm-25 ml-xs-25 mr-xs-25">
                    <input type="text" name="name" class="form-control" id="name" value="{{ old('name') }}" placeholder="Enter Brand name" required>
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
    <!--End Brand Modal -->




    @endsection
