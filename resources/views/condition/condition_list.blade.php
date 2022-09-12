@extends('master')

@section('title')
    Catalogue | Condition | WMS360
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
                        <li class="breadcrumb-item"> Catalogue </li>
                        <li class="breadcrumb-item active" aria-current="page"> Conditions </li>
                    </ol>
                    <div class="breadcrumbRightSideBtn">
                        <a href="#addCondition" data-animation="slit" data-plugin="custommodal" data-overlaySpeed="100" data-overlayColor="#36404a"><button class="btn btn-default">Add Condition</button></a>
                    </div>
                </div>

{{--                @if (Session::has('error'))--}}
{{--                    <div class="alert alert-danger">--}}
{{--                        {!! Session::get('error') !!}--}}
{{--                    </div>--}}
{{--                @endif--}}
{{--                @if (Session::has('success'))--}}
{{--                    <div class="alert alert-success">--}}
{{--                        {!! Session::get('success') !!}--}}
{{--                    </div>--}}
{{--                @endif--}}

                <div class="row m-t-20">

                    <div class="col-md-12">
                        <div class="card-box table-responsive shadow">

                            <div class="d-flex m-b-10">
                                <form action="{{url('make-default-condition')}}" method="post">
                                    @csrf
                                    <div class="input-group">
                                        <select class="form-control" name="condition_id" required>
                                            @isset($all_conditions)
                                                @if($all_conditions->count() == 1)
                                                    @foreach($all_conditions as $condition)
                                                        <option value="{{$condition->id}}" {{$condition->default_select == 1 ? 'selected' : ''}}>{{$condition->condition_name}}</option>
                                                    @endforeach
                                                @else
                                                    <option hidden>Select Option</option>
                                                    @foreach($all_conditions as $condition)
                                                        <option value="{{$condition->id}}" {{$condition->default_select == 1 ? 'selected' : ''}}>{{$condition->condition_name}}</option>
                                                    @endforeach
                                                @endif
                                            @endisset
                                        </select>
                                        <button type="submit" class="btn btn-primary m-l-5">Make default</button>
                                    </div>
                                </form>
                            </div>


                            @if (Session::has('error'))
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    {!! Session::get('error') !!}
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif

                            @if (Session::has('success'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    {!! Session::get('success') !!}
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif

                            @if (Session::has('condition_deleted_successfully'))
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    {!! Session::get('condition_deleted_successfully') !!}
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif


                            <table class="brand-list-table w-100">
                                <thead>
                                <tr>
                                    <th>Condition Name</th>
                                    <th>Default Select</th>
                                    <th style="width: 10%">Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                @isset($all_conditions)
                                    @foreach($all_conditions as $conditions)
                                        <tr>
                                            <td>{{$conditions->condition_name}}</td>
                                            <td>{{$conditions->default_select == 1 ? 'Yes' : ''}}</td>
                                            <td style="width: 10%">
                                                <div class="d-flex justify-content-start">
                                                    {{--                                                <a href="{{url('condition/'.$conditions->id.'/edit')}}" ><button class="vendor_btn_edit btn-primary">Edit</button></a>&nbsp;--}}
                                                    <a class="btn-size edit-btn mr-2" href="#editConditionList{{$conditions->id}}" data-animation="slit" data-plugin="custommodal"
                                                       data-overlaySpeed="100" data-overlayColor="#36404a"  data-placement="top" title="Edit"><i class="fa fa-edit" aria-hidden="true"></i></a>&nbsp;
                                                    <form action="{{url('condition/'.$conditions->id)}}" method="post">
                                                        @method('DELETE')
                                                        @csrf
                                                        <button style="cursor: pointer" type="submit" class="btn-size delete-btn on-default remove-row" onclick="return check_delete('Condition');" data-toggle="tooltip"  data-placement="top" title="Delete"><i class="fa fa-trash" aria-hidden="true"></i></button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>



                                        <!-- Edit condition Modal -->
                                        <div id="editConditionList{{$conditions->id}}" class="modal-demo">
                                            <button type="button" class="close" onclick="Custombox.close();">
                                                <span>&times;</span><span class="sr-only">Close</span>
                                            </button>
                                            <h4 class="custom-modal-title">Edit Condition Name</h4>
                                            <form role="form" class="vendor-form mobile-responsive" action="{{url('condition/'.$conditions->id)}}" method="post">
                                                @method('PUT')
                                                @csrf
                                                <div class="form-group c_condition_name row">
                                                    <label for="name" class="col-md-3 col-form-label ml-sm-25 mr-sm-25 ml-xs-25 mr-xs-25 required">Condition Name</label>
                                                    <div class="col-md-9 ml-sm-25 mr-sm-25 ml-xs-25 mr-xs-25">
                                                        <input type="text" name="condition_name" class="form-control" id="condition_name" value="{{ $conditions->condition_name ?? old('condition_name') }}" placeholder="Enter Condition name" required>
                                                    </div>
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
                                        <!--End Editcondition Modal -->


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


    <!-- Add Condition Modal -->
    <div id="addCondition" class="modal-demo">
        <button type="button" class="close" onclick="Custombox.close();">
            <span>&times;</span><span class="sr-only">Close</span>
        </button>
        <h4 class="custom-modal-title">Add Condition</h4>
        {{--                                <div class="modal-body">--}}

        <form role="form" class="vendor-form mobile-responsive" action="{{url('condition')}}" method="post">
            @csrf
            <div class="form-group c_condition_name row">
                <label for="name" class="col-md-3 col-form-label ml-sm-25 mr-sm-25 ml-xs-25 mr-xs-25 required">Condition Name</label>
                <div class="col-md-9 ml-sm-25 mr-sm-25 ml-xs-25 mr-xs-25">
                    <input type="text" name="condition_name" class="form-control" id="condition_name" value="{{ old('condition_name') }}" placeholder="Enter Condition Name" required>
                </div>
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
    <!--End Add Condition Modal-->



@endsection
