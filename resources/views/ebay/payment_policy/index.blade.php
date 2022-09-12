
@extends('master')

@section('title')
    eBay Payment Policy | WMS360
@endsection


@section('content')

    <link href="{{asset('assets/css/select2.min.css')}}" rel="stylesheet" type="text/css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>

    <!-- Custombox -->
    <link href="{{asset('assets/plugins/custombox/css/custombox.css')}}" rel="stylesheet">

    <!-- Modal-Effect -->
    <script src="{{asset('assets/plugins/custombox/js/custombox.min.js')}}"></script>
    <script src="{{asset('assets/plugins/custombox/js/legacy.min.js')}}"></script>


    <style>
        #div1, #div2 {
            float: left;
            width: 100px;
            height: 35px;
            margin: 10px;
            padding: 10px;
            border: 1px solid black;
        }
    </style>


    <script>
        function allowDrop(ev) {
            ev.preventDefault();
        }

        function drag(ev) {
            ev.dataTransfer.setData("text", ev.target.id);
        }

        function drop(ev) {
            ev.preventDefault();
            var data = ev.dataTransfer.getData("text");
            ev.target.appendChild(document.getElementById(data));
        }
    </script>


    <div class="content-page">
        <!-- Start content -->
        <div class="content">
            <div class="container-fluid">

                <div class="wms-breadcrumb">
                    <ol class="breadcrumb page-breadcrumb">
                        <li class="breadcrumb-item">eBay</li>
                        <li class="breadcrumb-item active" aria-current="page">Payment Policy</li>
                    </ol>
                    <div class="breadcrumbRightSideBtn">
                        <a href="#addPaymentPolicy" data-animation="slit" data-plugin="custommodal" data-overlaySpeed="100" data-overlayColor="#36404a"><button class="btn btn-default waves-effect waves-light"> Add Payment Policy </button></a>
                    </div>
                </div>

                <div class="row m-t-20">
                    {{--                    <div id="div1" ondrop="drop(event)" ondragover="allowDrop(event)">--}}
                    {{--                        <img src="img_w3slogo.gif" draggable="true" ondragstart="drag(event)" id="drag1" width="88" height="31">--}}
                    {{--                    </div>--}}

                    {{--                    <div id="div2" ondrop="drop(event)" ondragover="allowDrop(event)"></div>--}}
                    <div class="col-md-12">
                        <div class="card-box ebay table-responsive ebay-card-box shadow">

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
                                    <th>Payment Policy ID</th>
                                    <th>Site Name</th>
                                    <th>Payment Policy Name</th>
                                    <th>Payment Policy Description</th>
                                    <th>Account Name</th>
                                    <th style="width: 8%">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @isset($results)
                                    @foreach($results as $result)
                                        <tr>
                                            <td>{{$result->payment_id}}</td>
                                            <td>
                                                {{\App\EbaySites::find($result->site_id)->name}}
                                            </td>

                                            <td>{{$result->payment_name}}</td>
                                            <td>{{$result->payment_description}}</td>
                                            <td>{{\App\EbayAccount::find($result->account_id)->account_name ?? ''}}</td>
                                            <td style="width: 8%">
                                                <div class="action-1 align-items-center">
                                                    <div class="align-items-center mr-2">
                                                        <a class="btn-size edit-btn"  href="#editPaymentPolicy{{$result->id}}" data-animation="slit" data-plugin="custommodal" data-overlaySpeed="100" data-overlayColor="#36404a" data-placement="top" title="Edit"><i class="fa fa-edit" aria-hidden="true"></i></a>
{{--                                                                    <a class="btn-size edit-btn" href="{{URL::to('payment-policy/'.$result->id.'/edit')}}" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-edit" aria-hidden="true"></i></a>--}}
                                                    </div>
                                                    {{--                                                <a href="{{url('attribute/'.$attribute->id)}}" ><button class="vendor_btn_view btn-success">View</button></a>&nbsp;--}}
                                                    <div class="align-items-center">
                                                        <form action="{{url('payment-policy/'.$result->id)}}" method="post">
                                                            @method('DELETE')
                                                            @csrf
{{--                                                                        <a href="#" class="on-default remove-row" ><button class="vendor_btn_delete btn-danger" onclick="return check_delete('attribute');">Delete</button>  </a>--}}
                                                            <button class="btn-size del-pub del-pub-n delete-btn on-default remove-row" style="cursor: pointer" data-toggle="tooltip" data-placement="top" title="Delete" onclick="return check_delete('attribute');"><i class="fa fa-trash" aria-hidden="true"></i></button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>


                                        <!-- Edit payment policy Modal -->
                                        <div id="editPaymentPolicy{{$result->id}}" class="modal-demo">
                                            <button type="button" class="close" onclick="Custombox.close();">
                                                <span>&times;</span><span class="sr-only">Close</span>
                                            </button>
                                            <h4 class="custom-modal-title">Edit Payment Policy</h4>
                                            <form role="form" class="vendor-form mobile-responsive" action="{{URL::to('payment-policy/'.$result->id)}}" method="post">
                                                @method('PUT')
                                                @csrf

                                                <div class="form-group row">
                                                    <div class="col-md-1"></div>
                                                    <label for="name" class="col-md-3 col-form-label ml-sm-25 mr-sm-25 ml-xs-25 mr-xs-25 required">Payment ID</label>
                                                    <div class="col-md-7 ml-sm-25 mr-sm-25 ml-xs-25 mr-xs-25">
                                                        <input id="payment_id" type="text" class="form-control @error('payment_id') is-invalid @enderror" name="payment_id" value="{{$result->payment_id}}" maxlength="80" onkeyup="Count();" required autocomplete="payment_id" autofocus>
                                                        <span id="display" class="float-right"></span>
                                                        @error('payment_id')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                        @enderror
                                                    </div>
                                                    <div class="col-md-1"></div>
                                                </div>

                                                <div class="form-group row">
                                                    <div class="col-md-1"></div>
                                                    <label for="name" class="col-md-3 col-form-label ml-sm-25 mr-sm-25 ml-xs-25 mr-xs-25 required">Payment Name</label>
                                                    <div class="col-md-7 ml-sm-25 mr-sm-25 ml-xs-25 mr-xs-25">
                                                        <input id="payment_name" type="text" class="form-control @error('payment_name') is-invalid @enderror" name="payment_name" value="{{$result->payment_name}}" maxlength="80" onkeyup="Count();" required autocomplete="payment_name" autofocus>
                                                        <span id="display" class="float-right"></span>
                                                        @error('payment_name')
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
                                                        <select class="form-control select2 @error('account_id') is-invalid @enderror" name="account_id"  required autocomplete="account_id" autofocus>
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
                                                    <label for="payment_description" class="col-md-3 col-form-label ml-sm-25 mr-sm-25 ml-xs-25 mr-xs-25 required">Payment Description</label>
                                                    <div class="col-md-7 ml-sm-25 mr-sm-25 ml-xs-25 mr-xs-25">
                                                        <textarea name="payment_description" class="w-100 form-control" autocomplete="payment_description" autofocus>{{$result->payment_description}}</textarea>
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
                                        <!--End Edit payment policy Modal -->



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




    <!-- Add payment Policy Modal -->
    <div id="addPaymentPolicy" class="modal-demo">
        <button type="button" class="close" onclick="Custombox.close();">
            <span>&times;</span><span class="sr-only">Close</span>
        </button>
        <h4 class="custom-modal-title">Add Payment Policy</h4>

        <form role="form" class="vendor-form mobile-responsive" action="{{URL::to('payment-policy')}}" method="post">
            @csrf

            <div class="form-group row">
                <div class="col-md-1"></div>
                <label for="name" class="col-md-3 col-form-label ml-sm-25 mr-sm-25 ml-xs-25 mr-xs-25 required">Payment ID</label>
                <div class="col-md-7 ml-sm-25 mr-sm-25 ml-xs-25 mr-xs-25">
                    <input id="payment_id" type="text" class="form-control @error('payment_id') is-invalid @enderror" name="payment_id" value="" maxlength="80" onkeyup="Count();" required autocomplete="payment_id" autofocus>
                    <span id="display" class="float-right"></span>
                    @error('payment_id')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="col-md-1"></div>
            </div>

            <div class="form-group row">
                <div class="col-md-1"></div>
                <label for="name" class="col-md-3 col-form-label ml-sm-25 mr-sm-25 ml-xs-25 mr-xs-25 required">Payment Name</label>
                <div class="col-md-7 ml-sm-25 mr-sm-25 ml-xs-25 mr-xs-25">
                    <input id="payment_name" type="text" class="form-control @error('payment_name') is-invalid @enderror" name="payment_name" value="" maxlength="80" onkeyup="Count();" required autocomplete="payment_name" autofocus>
                    <span id="display" class="float-right"></span>
                    @error('payment_name')
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
                <label for="return_description" class="col-md-3 col-form-label ml-sm-25 mr-sm-25 ml-xs-25 mr-xs-25 required">Payment Description</label>
                <div class="col-md-7 ml-sm-25 mr-sm-25 ml-xs-25 mr-xs-25">
                    <textarea name="payment_description" class="w-100 form-control" autocomplete="payment_description" autofocus></textarea>
                    <span id="display" class="float-right"></span>
                    @error('payment_description')
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
    <!--End payment policy Modal -->


    <script>
        $('.select2').select2();
    </script>


@endsection
