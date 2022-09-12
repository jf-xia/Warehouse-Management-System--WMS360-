
@extends('master')

@section('title')
    eBay Paypal | WMS360
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
                        <li class="breadcrumb-item active" aria-current="page">Paypal Account</li>
                    </ol>
                    <div class="breadcrumbRightSideBtn">
                        <a href="#addPaypal" data-animation="slit" data-plugin="custommodal" data-overlaySpeed="100" data-overlayColor="#36404a"><button class="btn btn-default waves-effect waves-light">Add Paypal Account</button></a>
                    </div>
                </div>

                <div class="row m-t-20">
                    {{--                    <div id="div1" ondrop="drop(event)" ondragover="allowDrop(event)">--}}
                    {{--                        <img src="img_w3slogo.gif" draggable="true" ondragstart="drag(event)" id="drag1" width="88" height="31">--}}
                    {{--                    </div>--}}

                    {{--                    <div id="div2" ondrop="drop(event)" ondragover="allowDrop(event)"></div>--}}
                    <div class="col-md-12">
                        <div class="card-box table-responsive shadow">

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
                                    <th>Paypal Account Email</th>
                                    <th>Site Name</th>
                                    <th>Account Name</th>
                                    <th style="width: 15%">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @isset($results)
                                    @foreach($results as $result)
                                        <tr>
                                            <td>{{$result->paypal_email}}</td>
                                            <td>
                                                {{\App\EbaySites::find($result->site_id)->name}}
                                            </td>

                                            <td>{{\App\EbayAccount::find($result->account_id)->account_name }}</td>
                                            <td style="width: 15%">
                                                <div class="action-1 align-items-center">
                                                    <a class="btn-size paypal-btn-size edit-btn mr-2" href="#editPaypal{{$result->id}}" data-animation="slit" data-plugin="custommodal" data-overlaySpeed="100" data-overlayColor="#36404a" data-placement="top" title="Edit"><i class="fa fa-edit" aria-hidden="true"></i></a>
{{--                                                    <a href="{{URL::to('ebay-paypal/'.$result->id.'/edit')}}"><button class="vendor_btn_edit btn-primary">Edit</button></a>--}}
                                                    <form action="{{url('ebay-paypal/'.$result->id)}}" method="post">
                                                        @csrf
                                                        @method('DELETE')
{{--                                                        <a href="#" class="on-default remove-row"><button class="del-pub delete-btn" style="cursor: pointer" onclick="return check_delete('attribute');"><i class="fa fa-trash" aria-hidden="true"></i></button>  </a>--}}
                                                        <button class="del-pub del-pub-n delete-btn on-default remove-row" style="cursor: pointer" onclick="return check_delete('attribute');" data-placement="top" title="Delete"><i class="fa fa-trash" aria-hidden="true"></i></button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>


                                        <!-- Edit paypal Modal -->
                                        <div id="editPaypal{{$result->id}}" class="modal-demo">
                                            <button type="button" class="close" onclick="Custombox.close();">
                                                <span>&times;</span><span class="sr-only">Close</span>
                                            </button>
                                            <h4 class="custom-modal-title">Edit Paypal Account</h4>
                                            <form role="form" class="vendor-form mobile-responsive" action="{{URL::to('ebay-paypal/'.$result->id)}}" method="post">
                                                @method('PUT')
                                                @csrf

                                                <div class="form-group row">
                                                    <div class="col-md-1"></div>
                                                    <label for="paypal_email" class="col-md-3 col-form-label ml-sm-25 mr-sm-25 ml-xs-25 mr-xs-25 required">Paypal Email Name</label>
                                                    <div class="col-md-7 ml-sm-25 mr-sm-25 ml-xs-25 mr-xs-25">
                                                        <input id="paypal_email" type="text" class="form-control @error('paypal_email') is-invalid @enderror" name="paypal_email" value="{{$result->paypal_email}}" maxlength="80" onkeyup="Count();" required autocomplete="paypal_email" autofocus>
                                                        <span id="display" class="float-right"></span>
                                                        @error('paypal_email')
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
                                                        <select class="form-control select2 @error('site_id') is-invalid @enderror"    required autocomplete="site_id" autofocus>
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
                                                    <div class="col-md-12 text-center mb-5 mt-4">
                                                        <button type="submit" class="btn btn-primary vendor-btn waves-effect waves-light">
                                                            <b>Update</b>
                                                        </button>
                                                    </div>
                                                </div>

                                            </form>
                                        </div>
                                        <!--End Edit paypal Modal -->

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



    <!-- Add Paypal Modal -->
    <div id="addPaypal" class="modal-demo">
        <button type="button" class="close" onclick="Custombox.close();">
            <span>&times;</span><span class="sr-only">Close</span>
        </button>
        <h4 class="custom-modal-title">Add Paypal Account</h4>

        <form role="form" class="vendor-form mobile-responsive" action="{{URL::to('ebay-paypal')}}" method="post">
            @csrf

            <div class="form-group row">
                <div class="col-md-1"></div>
                <label for="paypal_email" class="col-md-3 col-form-label ml-sm-25 mr-sm-25 ml-xs-25 mr-xs-25 required">Paypel Email</label>
                <div class="col-md-7 ml-sm-25 mr-sm-25 ml-xs-25 mr-xs-25">
                    <input id="paypal_email" type="text" class="form-control @error('paypal_email') is-invalid @enderror" name="paypal_email" value="" maxlength="80" onkeyup="Count();" required autocomplete="paypal_email" autofocus>
                    <span id="display" class="float-right"></span>
                    @error('paypal_email')
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
                    <select class="form-control select2 @error('site_id') is-invalid @enderror"  name="site_id"  required autocomplete="site_id" autofocus>
{{--                        <option value="1" disabled>Select Site Name</option>--}}
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
                    <select class="form-control select2 @error('account_id') is-invalid @enderror"  name="account_id"  required autocomplete="account_id" autofocus>
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
                <div class="col-md-12 text-center mb-5 mt-4">
                    <button type="submit" class="btn btn-primary vendor-btn waves-effect waves-light">
                        <b>Add</b>
                    </button>
                </div>
            </div>

        </form>
    </div>
    <!--End Paypal Modal -->



    <script>
        $('.select2').select2();
    </script>


{{--        <script>--}}
{{--        $('.select2').select2({--}}
{{--            placeholder: "Select site",--}}
{{--            allowClear: true--}}
{{--        });--}}
{{--       </script>--}}



@endsection
