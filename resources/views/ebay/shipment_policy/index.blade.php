
@extends('master')

@section('title')
    eBay Shipment Policy | WMS360
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
                        <li class="breadcrumb-item">eBay</li>
                        <li class="breadcrumb-item active" aria-current="page">Shipment Policy</li>
                    </ol>
                    <div class="breadcrumbRightSideBtn">
                        <a href="#addShipmentPolicy" data-animation="slit" data-plugin="custommodal" data-overlaySpeed="100" data-overlayColor="#36404a"><button class="btn btn-default waves-effect waves-light"> Add Shipment Policy </button></a>
                    </div>
                </div>


                <div class="row m-t-20">
                    {{--                    <div id="div1" ondrop="drop(event)" ondragover="allowDrop(event)">--}}
                    {{--                        <img src="img_w3slogo.gif" draggable="true" ondragstart="drag(event)" id="drag1" width="88" height="31">--}}
                    {{--                    </div>--}}

                    {{--                    <div id="div2" ondrop="drop(event)" ondragover="allowDrop(event)"></div>--}}
                    <div class="col-md-12">
                        <div class="card-box ebay ebay-card-box table-responsive shadow">



                            @if (Session::has('attribute_delete_success_msg'))
                                <div class="alert alert-danger">
                                    {!! Session::get('attribute_delete_success_msg') !!}
                                </div>
                            @endif

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



                            <table class="ebay-table ebay-table-n w-100 table-primary-btm">
                                <thead>
                                <tr>
                                    <th style="width: 10%;">Shipment Policy ID</th>
                                    <th style="width: 8%; text-align: center">Site Name</th>
                                    <th>Shipment Policy Name</th>
                                    <th>Shipment Policy Description</th>
                                    <th style="width: 8%; text-align: center">Account Name</th>
                                    <th style="width: 8%">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @isset($results)
                                    @foreach($results as $result)
                                        <tr>
                                            <td style="width: 10%;">{{$result->shipment_id}}</td>
                                            <td style="width: 8%; text-align: center !important;">
                                                {{\App\EbaySites::find($result->site_id)->name}}
                                            </td>
                                            <td>{{$result->shipment_name}}</td>
                                            <td>{{$result->shipment_description}}</td>
                                            <td style="width: 8%; text-align: center !important;" >{{\App\EbayAccount::find($result->account_id)->account_name ?? '' }}</td>
                                            <td style="width: 8%">
{{--                                                <div class="btn-group dropup">--}}
{{--                                                    <button type="button" class="btn manage-btn dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">--}}
{{--                                                        Manage--}}
{{--                                                    </button>--}}
{{--                                                    <div class="dropdown-menu">--}}
{{--                                                        <!-- Dropdown menu links -->--}}
{{--                                                        <div class="dropup-content">--}}
                                                            <div class="action-1 align-items-center">
                                                                <div class="align-items-center mr-2">
                                                                    <a class="btn-size edit-btn"  href="#editShipmentPolicy{{$result->id}}" data-animation="slit" data-plugin="custommodal" data-overlaySpeed="100" data-overlayColor="#36404a" data-placement="top" title="Edit"><i class="fa fa-edit" aria-hidden="true"></i></a>
{{--                                                                    <a class="btn-size edit-btn" href="{{URL::to('shipment-policy/'.$result->id.'/edit')}}" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-edit" aria-hidden="true"></i></a>--}}
                                                                </div>
                                                                {{--                                                <a href="{{url('attribute/'.$attribute->id)}}" ><button class="vendor_btn_view btn-success">View</button></a>&nbsp;--}}
                                                                <div>
                                                                    <form action="{{url('shipment-policy/'.$result->id)}}" method="post">
                                                                        @method('DELETE')
                                                                        @csrf
{{--                                                                        <a href="#" class="on-default remove-row" ><button class="vendor_btn_delete btn-danger" onclick="return check_delete('attribute');">Delete</button>  </a>--}}
                                                                        <button class="btn-size del-pub del-pub-n delete-btn on-default remove-row" style="cursor: pointer" data-toggle="tooltip" data-placement="top" title="Delete" onclick="return check_delete('attribute');"><i class="fa fa-trash" aria-hidden="true"></i></button>
                                                                    </form>
                                                                </div>
                                                            </div>
{{--                                                        </div>--}}
{{--                                                    </div>--}}
{{--                                                </div>--}}
                                            </td>
                                        </tr>


                                        <!-- Edit shipment policy Modal -->
                                        <div id="editShipmentPolicy{{$result->id}}" class="modal-demo">
                                            <button type="button" class="close" onclick="Custombox.close();">
                                                <span>&times;</span><span class="sr-only">Close</span>
                                            </button>
                                            <h4 class="custom-modal-title">Edit Shipment Policy</h4>
                                            <form role="form" class="vendor-form mobile-responsive" action="{{URL::to('shipment-policy/'.$result->id)}}" method="post">
                                                @method('PUT')
                                                @csrf

                                                <div class="form-group row">
                                                    <div class="col-md-1"></div>
                                                    <label for="name" class="col-md-3 col-form-label ml-sm-25 mr-sm-25 ml-xs-25 mr-xs-25 required">Shipment ID</label>
                                                    <div class="col-md-7 ml-sm-25 mr-sm-25 ml-xs-25 mr-xs-25">
                                                        <input id="shipment_id" type="text" class="form-control @error('shipment_id') is-invalid @enderror" name="shipment_id" value="{{$result->shipment_id}}" maxlength="80" onkeyup="Count();" required autocomplete="shipment_id" autofocus>
                                                        <span id="display" class="float-right"></span>
                                                        @error('shipment_id')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                        @enderror
                                                    </div>
                                                    <div class="col-md-1"></div>
                                                </div>

                                                <div class="form-group row">
                                                    <div class="col-md-1"></div>
                                                    <label for="name" class="col-md-3 col-form-label ml-sm-25 mr-sm-25 ml-xs-25 mr-xs-25 required">Shipment Name</label>
                                                    <div class="col-md-7 ml-sm-25 mr-sm-25 ml-xs-25 mr-xs-25">
                                                        <input id="shipment_name" type="text" class="form-control @error('shipment_name') is-invalid @enderror" name="shipment_name" value="{{$result->shipment_name}}" maxlength="80" onkeyup="Count();" required autocomplete="shipment_name" autofocus>
                                                        <span id="display" class="float-right"></span>
                                                        @error('shipment_name')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                        @enderror
                                                    </div>
                                                    <div class="col-md-1"></div>
                                                </div>

                                                <div class="form-group row">
                                                    <div class="col-md-1"></div>
                                                    <label for="category" class="col-md-3 col-form-label ml-sm-25 mr-sm-25 ml-xs-25 mr-xs-25 required">Site Name</label>
                                                    <div class="col-md-7 ml-sm-25 mr-sm-25 ml-xs-25 mr-xs-25">
                                                        <select class="form-control select2 @error('site_id') is-invalid @enderror" name="site_id"  required autocomplete="site_id" autofocus>
                                                            @foreach($sites as $site)
                                                                @if($site->id == $result->site_id)
                                                                    <option value="{{$site->id}}" selected>{{$site->name}}</option>
                                                                @else
                                                                    <option value="{{$site->id}}">{{$site->name}}</option>
                                                                @endif
                                                            @endforeach
                                                        </select>
                                                        @error('site')
                                                        <span class="invalid-feedback" role="alert">
                                                             <strong>{{ $message }}</strong>
                                                        </span>
                                                        @enderror
                                                    </div>
                                                    <div class="col-md-1"></div>
                                                </div>

                                                <div class="form-group row">
                                                    <div class="col-md-1"></div>
                                                    <label for="category" class="col-md-3 col-form-label ml-sm-25 mr-sm-25 ml-xs-25 mr-xs-25 required">Account Name</label>
                                                    <div class="col-md-7 ml-sm-25 mr-sm-25 ml-xs-25 mr-xs-25">
                                                        <select  class="form-control select2 @error('account_id') is-invalid @enderror" name="account_id"  required autocomplete="account_id" autofocus>
                                                            @foreach($accounts as $account)
                                                                @if($account->id == $result->account_id)
                                                                    <option value="{{$account->id}}" selected>{{$account->account_name}}</option>
                                                                @else
                                                                    <option value="{{$account->id}}">{{$account->account_name}}</option>
                                                                @endif
                                                            @endforeach
                                                        </select>
                                                        @error('account_id')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                        @enderror
                                                    </div>
                                                    <div class="col-md-1"></div>
                                                </div>

                                                <div class="form-group row">
                                                    <div class="col-md-1"></div>
                                                    <label for="shipment_description" class="col-md-3 col-form-label ml-sm-25 mr-sm-25 ml-xs-25 mr-xs-25 required">Shipment Description</label>
                                                    <div class="col-md-7 ml-sm-25 mr-sm-25 ml-xs-25 mr-xs-25">
                                                        <textarea name="shipment_description" class="w-100 form-control" autocomplete="shipment_description" autofocus>{{$result->shipment_description}}</textarea>
                                                        <span id="display" class="float-right"></span>
                                                        @error('name')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                        @enderror
                                                    </div>
                                                    <div class="col-md-1"></div>
                                                </div>

                                                <div class="form-group row">
                                                    <div class="col-md-12 text-center mb-5 mt-4">
                                                        <button type="submit" class="btn btn-primary vendor-btn waves-effect waves-light">
                                                            <b>Update</b>
                                                        </button>
                                                    </div>
                                                </div>

                                            </form>
                                        </div>
                                        <!--End shipment policy Modal -->


                                    @endforeach
                                @endisset
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div> <!-- end row -->
            </div> <!-- container -->
        </div> <!-- content -->

    </div>   <!-- content page -->





    <!-- Add Shipment Policy Modal -->
    <div id="addShipmentPolicy" class="modal-demo">
        <button type="button" class="close" onclick="Custombox.close();">
            <span>&times;</span><span class="sr-only">Close</span>
        </button>
        <h4 class="custom-modal-title">Add Shipment Policy</h4>

        <form role="form" class="vendor-form mobile-responsive" action="{{URL::to('shipment-policy')}}" method="post">
            @csrf

            <div class="form-group row">
                <div class="col-md-1"></div>
                <label for="name" class="col-md-3 col-form-label ml-sm-25 mr-sm-25 ml-xs-25 mr-xs-25 required">Shipment ID</label>
                <div class="col-md-7 ml-sm-25 mr-sm-25 ml-xs-25 mr-xs-25">
                    <input id="shipment_id" type="text" class="form-control @error('shipment_id') is-invalid @enderror" name="shipment_id" value="" maxlength="80" onkeyup="Count();" required autocomplete="shipment_id" autofocus>
                    <span id="display" class="float-right"></span>
                    @error('shipment_id')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="col-md-1"></div>
            </div>

            <div class="form-group row">
                <div class="col-md-1"></div>
                <label for="name" class="col-md-3 col-form-label ml-sm-25 mr-sm-25 ml-xs-25 mr-xs-25 required">Shipment Name</label>
                <div class="col-md-7 ml-sm-25 mr-sm-25 ml-xs-25 mr-xs-25">
                    <input id="shipment_name" type="text" class="form-control @error('shipment_name') is-invalid @enderror" name="shipment_name" value="" maxlength="80" onkeyup="Count();" required autocomplete="shipment_name" autofocus>
                    <span id="display" class="float-right"></span>
                    @error('shipment_name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="col-md-1"></div>
            </div>

            <div class="form-group row">
                <div class="col-md-1"></div>
                <label for="category" class="col-md-3 col-form-label ml-sm-25 mr-sm-25 ml-xs-25 mr-xs-25 required">Site Name</label>
                <div class="col-md-7 ml-sm-25 mr-sm-25 ml-xs-25 mr-xs-25">
                    <select id="site_id" class="form-control select2 @error('site_id') is-invalid @enderror"  name="site_id"  required autocomplete="site_id" autofocus>
                        @foreach($sites as $site)
                            <option value="{{$site->id}}">{{$site->name}}</option>
                        @endforeach
                    </select>
                    @error('site')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="col-md-1"></div>
            </div>

            <div class="form-group row">
                <div class="col-md-1"></div>
                <label for="category" class="col-md-3 col-form-label ml-sm-25 mr-sm-25 ml-xs-25 mr-xs-25 required">Account Name</label>
                <div class="col-md-7 ml-sm-25 mr-sm-25 ml-xs-25 mr-xs-25">
                    <select id="account_id" class="form-control select2 @error('account_id') is-invalid @enderror"  name="account_id"  required autocomplete="account_id" autofocus>
                        @foreach($accounts as $account)
                            <option value="{{$account->id}}">{{$account->account_name}}</option>
                        @endforeach
                    </select>
                    @error('site')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="col-md-1"></div>
            </div>

            <div class="form-group row">
                <div class="col-md-1"></div>
                <label for="return_description" class="col-md-3 col-form-label ml-sm-25 mr-sm-25 ml-xs-25 mr-xs-25 required">Shipment Description</label>
                <div class="col-md-7 ml-sm-25 mr-sm-25 ml-xs-25 mr-xs-25">
                    <textarea name="shipment_description" class="w-100 form-control" autocomplete="shipment_description" autofocus></textarea>
                    <span id="display" class="float-right"></span>
                    @error('shipment_description')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="col-md-1"></div>
            </div>

            <div class="form-group row">
                <div class="col-md-12 text-center mb-5 mt-4">
                    <button type="submit" class="btn btn-primary vendor-btn waves-effect waves-light">
                        <b>Add</b>
                    </button>
                </div>
            </div>

        </form>
    </div>
    <!--End Shipment Policy Modal -->


    <script>
        $('.select2').select2();
    </script>


@endsection
