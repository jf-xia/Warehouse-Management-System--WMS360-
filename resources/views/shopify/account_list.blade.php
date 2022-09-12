
@extends('master')

@section('title')
    Shopify Account | WMS360
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
                        <li class="breadcrumb-item">Shopify</li>
                        <li class="breadcrumb-item active" aria-current="page">Account List</li>
                    </ol>
                    <div class="breadcrumbRightSideBtn">
                        <a href="#addAccount" data-animation="slit" data-plugin="custommodal" data-overlaySpeed="100" data-overlayColor="#36404a"><button class="btn btn-default waves-effect waves-light"> Add Shopify Account </button></a>
                    </div>
                </div>


                <div class="row m-t-20">
                    {{--                    <div id="div1" ondrop="drop(event)" ondragover="allowDrop(event)">--}}
                    {{--                        <img src="img_w3slogo.gif" draggable="true" ondragstart="drag(event)" id="drag1" width="88" height="31">--}}
                    {{--                    </div>--}}

                    {{--                    <div id="div2" ondrop="drop(event)" ondragover="allowDrop(event)"></div>--}}
                    <div class="col-md-12">
                        <div class="card-box ebay ebay-card-box table-responsive shadow">

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
                                    <th>#Logo</th>
                                    <th>Shopify Account Name</th>
                                    <th>Sites</th>
                                    <th>Account Status</th>
                                    <th>Product Sync</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @isset($shopifyAccounts)
                                    @foreach($shopifyAccounts as $account_list)

                                        <tr>
                                            <td>
                                                @if(isset($account_list->account_logo))
                                                    <img height="50px" width="50px" src="{{$account_list->account_logo}}">

                                                @else
                                                    <img height="50px" width="50px" src="{{asset('assets/common-assets/shopify.png')}}">
                                                @endif

                                            </td>
                                            <td>{{$account_list->account_name}}</td>
                                            <td>{{$account_list->shop_url}}</td>
                                            @if($account_list->account_status == 1)
                                                <td><span class="label label-table label-primary label-status">Active</span></td>
                                            @else
                                                <td><span class="label label-table label-primary label-status">Inactive</span></td>
                                            @endif
{{--                                            <td>--}}
{{--                                                <div class="d-flex justify-content-start">--}}
{{--                                                    <div class="mr-2">--}}
{{--                                                        <form style="margin: 0px;" role="form" class="vendor-form mobile-responsive" action="" method="post">--}}
{{--                                                        @csrf--}}
{{--                                                            <a class="btn-size edit-btn" style="background: #4F7942;"  href="{{URL::to('shopify/product_sync/'.$account_list->id)}}" data-animation="slit" data-overlaySpeed="100" title="Order Sync"><i class="fa fa-sync" aria-hidden="true"></i></a>--}}
{{--                                                        </form>--}}
{{--                                                    </div>--}}
{{--                                                </div>--}}
{{--                                            </td>--}}
                                            <td>
                                                <div class="d-flex justify-content-start">
                                                    <div class="mr-2">
                                                        <a class="btn-size edit-btn"  href="#editAccountList{{$account_list->id}}" data-animation="slit" data-plugin="custommodal" data-overlaySpeed="100" data-overlayColor="#36404a" data-placement="top" title="Edit"><i class="fa fa-edit" aria-hidden="true"></i></a>
                                                        {{--                                                <a class="btn-size edit-btn" href="{{URL::to('ebay-edit-account/'.$account_list->id)}}" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-edit" aria-hidden="true"></i></a>&nbsp;--}}
                                                    </div>
                                                    <div class="mr-2">
                                                        <a class="btn-size btn-danger"  href="#deleteAccountList{{$account_list->id}}" data-animation="slit" data-plugin="custommodal" data-overlaySpeed="100" data-overlayColor="#36404a" data-placement="top" title="Delete"><i class="fa fa-remove" aria-hidden="true"></i></a>
                                                        {{--                                                <a class="btn-size edit-btn" href="{{URL::to('ebay-edit-account/'.$account_list->id)}}" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-edit" aria-hidden="true"></i></a>&nbsp;--}}
                                                    </div>
                                                    {{-- <div class="mr-2">
                                                        <a class="btn-size edit-btn" href="{{URL::to('shopify-sync-account/'.$account_list->id)}}" data-toggle="tooltip" data-placement="top" title="Sync Account"><i class="fa fa-location-arrow" aria-hidden="true"></i></a>
                                                    </div>
                                                    <div class="mr-2">
                                                        <a class="btn-size edit-btn" href="{{url('shopify-migration-list')}}" data-toggle="tooltip" data-placement="top" title="Migration List"><i class="fa fa-file-archive-o" aria-hidden="true"></i></a>
                                                    </div> --}}
                                                    {{--                                                <a href="{{url('attribute/'.$attribute->id)}}" ><button class="vendor_btn_view btn-success">View</button></a>&nbsp;--}}
                                                    {{--                                                <form action="{{url('attribute/'.$attribute->id)}}" method="post">--}}
                                                    {{--                                                    @method('DELETE')--}}
                                                    {{--                                                    @csrf--}}
                                                    {{--                                                    <a href="#" class="on-default remove-row" ><button class="vendor_btn_delete btn-danger" onclick="return check_delete('attribute');">Delete</button>  </a>--}}
                                                    {{--                                                </form>--}}
                                                </div>
                                            </td>
                                        </tr>

                                        <!-- Edit eBay account Modal -->
                                        <div id="editAccountList{{$account_list->id}}" class="modal-demo">
                                            <button type="button" class="close" onclick="Custombox.close();">
                                                <span>&times;</span><span class="sr-only">Close</span>
                                            </button>
                                            <h4 class="custom-modal-title">Edit Shopify Account</h4>
                                            <form role="form" class="vendor-form mobile-responsive" action="{{URL::to('shopify/shopify-edit-account/'.$account_list->id)}}" method="post" enctype="multipart/form-data">
                                                @csrf
                                                <div class="form-group row">
                                                    <div class="col-md-1"></div>
                                                    <label for="name" class="col-md-3 col-form-label ml-sm-25 mr-sm-25 ml-xs-25 mr-xs-25 required">Account Name</label>
                                                    <div class="col-md-7 ml-sm-25 mr-sm-25 ml-xs-25 mr-xs-25">
                                                        <input id="account_name" type="text" class="form-control @error('account_name') is-invalid @enderror" name="account_name" value="{{$account_list->account_name}}" maxlength="80" onkeyup="Count();" required autocomplete="account_name" autofocus>
                                                        <span id="display" class="float-right"></span>
                                                        @error('account_name')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                        @enderror
                                                    </div>
                                                    <div class="col-md-1"></div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-md-1"></div>
                                                    <label for="location" class="col-md-3 col-form-label ml-sm-25 mr-sm-25 ml-xs-25 mr-xs-25 required">Shop URL</label>
                                                    <div class="col-md-7 ml-sm-25 mr-sm-25 ml-xs-25 mr-xs-25">
                                                        <input id="shop_url" type="text" class="form-control @error('shop_url') is-invalid @enderror" name="shop_url" value="{{$account_list->shop_url}}" maxlength="80" onkeyup="Count();" required autocomplete="shop_url" autofocus>
                                                        <span id="shop_url" class="float-right"></span>
                                                        @error('shop_url')
                                                        <span class="invalid-feedback" role="alert">
                                                             <strong>{{ $message }}</strong>
                                                        </span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-md-1"></div>
                                                    <label for="post_code" class="col-md-3 col-form-label ml-sm-25 mr-sm-25 ml-xs-25 mr-xs-25 required">API Key</label>
                                                    <div class="col-md-7 ml-sm-25 mr-sm-25 ml-xs-25 mr-xs-25">
                                                        <input id="api_key" type="text" class="form-control @error('api_key') is-invalid @enderror" name="api_key" value="{{$account_list->api_key}}" maxlength="80" onkeyup="Count();" required autocomplete="api_key" autofocus>
                                                        <span id="api_key" class="float-right"></span>
                                                        @error('api_key')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-md-1"></div>
                                                    <label for="post_code" class="col-md-3 col-form-label ml-sm-25 mr-sm-25 ml-xs-25 mr-xs-25 required">Password</label>
                                                    <div class="col-md-7 ml-sm-25 mr-sm-25 ml-xs-25 mr-xs-25">
                                                        <input id="password" type="text" class="form-control @error('password') is-invalid @enderror" name="password" value="{{$account_list->password}}" maxlength="80" onkeyup="Count();" required autocomplete="password" autofocus>
                                                        <span id="password" class="float-right"></span>
                                                        @error('password')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-md-1"></div>
                                                    <label for="post_code" class="col-md-3 col-form-label ml-sm-25 mr-sm-25 ml-xs-25 mr-xs-25 required">Account Status</label>
                                                    <div class="col-md-7 ml-sm-25 mr-sm-25 ml-xs-25 mr-xs-25">
                                                        {{--                    <input id="account_status" type="text" class="form-control @error('account_status') is-invalid @enderror" name="account_status" value="" maxlength="80" onkeyup="Count();" required autocomplete="account_status" autofocus>--}}
                                                        <select name="account_status" id="account_status" class="form-control select2 select2-hidden-accessible">
                                                            @isset($account_list->account_status)
                                                                @if($account_list->account_status == 1)
                                                                    <option value="1" selected>Active</option>
                                                                    <option value="0">Inactive</option>
                                                                @else
                                                                    <option value="1" selected>Active</option>
                                                                    <option value="0" selected>Inactive</option>
                                                                @endisset
                                                            @endisset
                                                        </select>
                                                        <span id="account_status" class="float-right"></span>
                                                        @error('account_status')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-md-1"></div>
                                                    <label for="category" class="col-md-3 col-form-label ml-sm-25 mr-sm-25 ml-xs-25 mr-xs-25 required">Account Logo</label>
                                                    <div class="col-md-7 ml-sm-25 mr-sm-25 ml-xs-25 mr-xs-25">
                                                        <input type="file" name="account_logo">
                                                        @error('account_logo')
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
                                        <!--End Edit eBay account Modal -->

                                        {{--                                        account delete modal start--}}
                                        <div id="deleteAccountList{{$account_list->id}}" class="modal-demo">
                                            <button type="button" class="close" onclick="Custombox.close();">
                                                <span>&times;</span><span class="sr-only">Close</span>
                                            </button>
                                            <h4 class="custom-modal-title">Delete eBay Account</h4>
                                            <form role="form" class="vendor-form mobile-responsive" action="{{URL::to('shopify/shopify-delete-account/'.$account_list->id)}}" method="post" enctype="multipart/form-data">
                                                @csrf
                                                <h4 style="color:red; text-align: center;">You want to delete {{$account_list->account_name}} Account</h4>



{{--                                                <div class="form-group row">--}}
{{--                                                    <div class="col-md-1"></div>--}}
{{--                                                    <label for="category" class="col-md-3 col-form-label ml-sm-25 mr-sm-25 ml-xs-25 mr-xs-25 required">Delete Options</label>--}}
{{--                                                    <div class="col-md-7 ml-sm-25 mr-sm-25 ml-xs-25 mr-xs-25">--}}
{{--                                                        <select class="form-control select2 @error('delete_info') is-invalid @enderror" name="delete_info"  required  autofocus>--}}
{{--                                                            <option value="" disabled selected>Select Option</option>--}}
{{--                                                            <option value="1" >Delete Only WMS Listings</option>--}}
{{--                                                            <option value="2" >Delete Both WMS and eBay Listings</option>--}}
{{--                                                        </select>--}}
{{--                                                        @error('site')--}}
{{--                                                        <span class="invalid-feedback" role="alert">--}}
{{--                                                            <strong>{{ $message }}</strong>--}}
{{--                                                        </span>--}}
{{--                                                        @enderror--}}
{{--                                                    </div>--}}
{{--                                                    <div class="col-md-1"></div>--}}
{{--                                                </div>--}}



                                                <div class="form-group row">
                                                    <div class="col-md-12 text-center mb-5 mt-4">
                                                        <button type="submit" class="btn btn-primary vendor-btn waves-effect waves-light">
                                                            <b>Delete</b>
                                                        </button>
                                                    </div>
                                                </div>

                                            </form>
                                        </div>
                                        {{--account delete modal ends--}}




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


    <!-- Add eBay Account Modal -->
    <div id="addAccount" class="modal-demo">
        <button type="button" class="close" onclick="Custombox.close();">
            <span>&times;</span><span class="sr-only">Close</span>
        </button>
        <h4 class="custom-modal-title">Add Shopify Account</h4>

        <form role="form" class="vendor-form mobile-responsive" action="{{URL::to('shopify-create-account')}}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="form-group row">
                <div class="col-md-1"></div>
                <label for="name" class="col-md-3 col-form-label ml-sm-25 mr-sm-25 ml-xs-25 mr-xs-25 required">Account Name</label>
                <div class="col-md-7 ml-sm-25 mr-sm-25 ml-xs-25 mr-xs-25">
                    <input id="account_name" type="text" class="form-control @error('account_name') is-invalid @enderror" name="account_name" value="" maxlength="80" onkeyup="Count();" required autocomplete="account_name" autofocus>
                    <span id="display" class="float-right"></span>
                    @error('account_name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="col-md-1"></div>
            </div>
            <div class="form-group row">
                <div class="col-md-1"></div>
                <label for="location" class="col-md-3 col-form-label ml-sm-25 mr-sm-25 ml-xs-25 mr-xs-25 required">Shop URL</label>
                <div class="col-md-7 ml-sm-25 mr-sm-25 ml-xs-25 mr-xs-25">
                    <input id="shop_url" type="text" class="form-control @error('shop_url') is-invalid @enderror" name="shop_url" value="" maxlength="80" onkeyup="Count();" required autocomplete="shop_url" autofocus>
                    <span id="shop_url" class="float-right"></span>
                    @error('shop_url')
                    <span class="invalid-feedback" role="alert">
                         <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-1"></div>
                <label for="post_code" class="col-md-3 col-form-label ml-sm-25 mr-sm-25 ml-xs-25 mr-xs-25 required">API Key</label>
                <div class="col-md-7 ml-sm-25 mr-sm-25 ml-xs-25 mr-xs-25">
                    <input id="api_key" type="text" class="form-control @error('api_key') is-invalid @enderror" name="api_key" value="" maxlength="80" onkeyup="Count();" required autocomplete="api_key" autofocus>
                    <span id="api_key" class="float-right"></span>
                    @error('api_key')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-1"></div>
                <label for="post_code" class="col-md-3 col-form-label ml-sm-25 mr-sm-25 ml-xs-25 mr-xs-25 required">Password</label>
                <div class="col-md-7 ml-sm-25 mr-sm-25 ml-xs-25 mr-xs-25">
                    <input id="password" type="text" class="form-control @error('password') is-invalid @enderror" name="password" value="" maxlength="80" onkeyup="Count();" required autocomplete="password" autofocus>
                    <span id="password" class="float-right"></span>
                    @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-1"></div>
                <label for="post_code" class="col-md-3 col-form-label ml-sm-25 mr-sm-25 ml-xs-25 mr-xs-25 required">Account Status</label>
                <div class="col-md-7 ml-sm-25 mr-sm-25 ml-xs-25 mr-xs-25">
{{--                    <input id="account_status" type="text" class="form-control @error('account_status') is-invalid @enderror" name="account_status" value="" maxlength="80" onkeyup="Count();" required autocomplete="account_status" autofocus>--}}
                        <select name="account_status" id="account_status" class="select2">
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>
                    <span id="account_status" class="float-right"></span>
                    @error('account_status')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-1"></div>
                <label for="category" class="col-md-3 col-form-label ml-sm-25 mr-sm-25 ml-xs-25 mr-xs-25 required">Account Logo</label>
                <div class="col-md-7 ml-sm-25 mr-sm-25 ml-xs-25 mr-xs-25">
                    <input type="file" name="account_logo">
                    @error('account_logo')
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
    <!--End eBay account Modal -->


    <script>
        $('.select2').select2();
    </script>



@endsection
