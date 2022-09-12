
@extends('master')

@section('title')
    eBay Account | WMS360
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
            border: 1px solid #000000;
        }
        .anchor-disabled {
            pointer-events: none;
            cursor: default;
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
                        <li class="breadcrumb-item active" aria-current="page">Account List</li>
                    </ol>
                    <div class="breadcrumbRightSideBtn">
                        <a href="#addAccount" data-animation="slit" data-plugin="custommodal" data-overlaySpeed="100" data-overlayColor="#36404a"><button class="btn btn-default waves-effect waves-light"> Add eBay Account </button></a>
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
                                    <th class="text-center">Channel Logo</th>
                                    <th class="text-center">eBay Username</th>
                                    <th class="text-center">eBay Sites</th>
                                    <th class="text-center">Connection Expires</th>
                                    <th class="text-center">Open Authorization</th>
                                    <th class="text-center">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @isset($account_lists)
                                    @foreach($account_lists as $account_list)

                                        <tr>
                                            <td class="text-center">
                                                @if(isset($account_list->logo))
                                                    <img height="50px" width="auto" src="{{$account_list->logo}}">

                                                @else
                                                    <img height="50px" width="50px" src="{{asset('assets/common-assets/no_image.jpg')}}">
                                                @endif

                                            </td>
                                            <td class="text-center">{{$account_list->account_name}}</td>

                                            <td class="text-center w-30">
                                                @isset($account_list->sites)
                                                    @foreach($account_list->sites as $site)
                                                        {{$site->name}},
                                                    @endforeach
                                                @endif
                                            </td>

                                            <td class="text-center">{{$account_list->expiry_date}}</td>
                                            <td class="text-center">

                                                    <span class="d-flex align-items-center">
                                                        @if(!$status[$account_list->id])
                                                            <span class="mr-2" title="Broken"><i class="fas fa-unlink text-danger font-18"></i></span>
                                                        @else
                                                            <span class="mr-2" title="Linked"><i class="fas fa-link text-success font-18"></i></i></span>
                                                        @endif
                                                        <span>
                                                            <input type="hidden" name="account_id" value="{{$account_list->id}}">
                                                            <input type="hidden" name="site_id" value="{{$site->id ?? ''}}">
{{--                                                            <input type="hidden" name="sign_in_link" value="{{$developer_accounts[0]->sign_in_link}}">--}}
                                                            <a href="{{$developer_accounts[0]->sign_in_link}}" onclick="openAndSave({{$account_list->id}})" class="btn btn-default open-authorization-btn">Authorize Account</a>
                                                        </span>
                                                    </span>
                                            </td>
                                            <td>
                                                <div class="d-flex justify-content-center">
                                                    <div class="mr-2">
                                                        <a class="btn-size edit-btn"  href="#editAccountList{{$account_list->id}}" data-animation="slit" data-plugin="custommodal" data-overlaySpeed="100" data-overlayColor="#36404a" data-placement="top" title="Edit"><i class="fa fa-edit" aria-hidden="true"></i></a>
                                                        {{--                                                <a class="btn-size edit-btn" href="{{URL::to('ebay-edit-account/'.$account_list->id)}}" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-edit" aria-hidden="true"></i></a>&nbsp;--}}
                                                    </div>

                                                    <div class="mr-2">
                                                        @if(!$status[$account_list->id])
                                                            <a onclick="getMigration({{$account_list->id}})" class="btn-size anchor-disabled bg-secondary text-white" href="#" data-toggle="tooltip" data-placement="top" title="Sync Account"><i id="a{{$account_list->id}}" class="fas fa-sync" aria-hidden="true"></i></a>
                                                        @else
                                                            <a onclick="getMigration({{$account_list->id}})" class="btn-size edit-btn" href="#" data-toggle="tooltip" data-placement="top" title="Sync Account"><i id="a{{$account_list->id}}" class="fas fa-sync" aria-hidden="true"></i></a>
                                                        @endif

                                                    </div>
                                                    <div class="mr-2">
                                                        <a class="btn-size edit-btn" href="{{url('ebay-migration-list')}}" data-toggle="tooltip" data-placement="top" title="Migration List"><i class="fas fa-file-import" aria-hidden="true"></i></a>
                                                    </div>
                                                    {{--                                                <a href="{{url('attribute/'.$attribute->id)}}" ><button class="vendor_btn_view btn-success">View</button></a>&nbsp;--}}
                                                    {{--                                                <form action="{{url('attribute/'.$attribute->id)}}" method="post">--}}
                                                    {{--                                                    @method('DELETE')--}}
                                                    {{--                                                    @csrf--}}
                                                    {{--                                                    <a href="#" class="on-default remove-row" ><button class="vendor_btn_delete btn-danger" onclick="return check_delete('attribute');">Delete</button>  </a>--}}
                                                    {{--                                                </form>--}}
                                                    <div class="mr-2">
                                                        <a class="btn-size btn-danger"  href="#deleteAccountList{{$account_list->id}}" data-animation="slit" data-plugin="custommodal" data-overlaySpeed="100" data-overlayColor="#36404a" data-placement="top" title="Delete"><i class="fas fa-trash-alt"></i></a>
                                                        {{--                                                <a class="btn-size edit-btn" href="{{URL::to('ebay-edit-account/'.$account_list->id)}}" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-edit" aria-hidden="true"></i></a>&nbsp;--}}
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>

                                        <!-- Edit eBay account Modal -->
                                        <div id="editAccountList{{$account_list->id}}" class="modal-demo">
                                            <button type="button" class="close" onclick="Custombox.close();">
                                                <span>&times;</span><span class="sr-only">Close</span>
                                            </button>
                                            <h4 class="custom-modal-title">Edit eBay Account</h4>
                                            <form role="form" class="vendor-form mobile-responsive" action="{{URL::to('ebay-update-account/'.$account_list->id)}}" method="post" enctype="multipart/form-data">
                                                @csrf

                                                <div class="form-group row">
                                                    <div class="col-md-1"></div>
                                                    <label for="name" class="col-md-3 col-form-label ml-sm-25 mr-sm-25 ml-xs-25 mr-xs-25 required">eBay User Name</label>
                                                    <div class="col-md-7 ml-sm-25 mr-sm-25 ml-xs-25 mr-xs-25">
                                                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="account_name" value="{{$account_list->account_name}}" maxlength="80" onkeyup="Count();" required autocomplete="name" autofocus>
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
                                                    <div class="col-md-1"></div>
                                                    <label for="feeder_quantity" class="col-md-3 col-form-label ml-sm-25 mr-sm-25 ml-xs-25 mr-xs-25 required">Feeder Quantity</label>
                                                    <div class="col-md-7 ml-sm-25 mr-sm-25 ml-xs-25 mr-xs-25">
                                                        <input id="feeder_quantity" type="text" class="form-control @error('feeder_quantity') is-invalid @enderror" name="feeder_quantity" value="{{$account_list->feeder_quantity}}" maxlength="80" onkeyup="Count();" required autocomplete="name" autofocus>
                                                        <span id="display" class="float-right"></span>
                                                        @error('feeder_quantity')
                                                        <span class="invalid-feedback" role="alert">
                                                             <strong>{{ $message }}</strong>
                                                        </span>
                                                        @enderror
                                                    </div>
                                                    <div class="col-md-1"></div>
                                                </div>

                                                <div class="form-group row">
                                                    <div class="col-md-1"></div>
                                                    <label for="category" class="col-md-3 col-form-label ml-sm-25 mr-sm-25 ml-xs-25 mr-xs-25 required">Site</label>
                                                    <div class="col-md-7 ml-sm-25 mr-sm-25 ml-xs-25 mr-xs-25">
                                                        <select class="form-control select2 @error('site') is-invalid @enderror" multiple="multiple" name="site_id[]" value="{{ old('site_id') }}" required autocomplete="site_id" autofocus>
                                                            @foreach($sites as $site)
                                                                @foreach($account_list->sites as $account_sites)
                                                                    @if($site->id == $account_sites->id)
                                                                        <option value="{{$site->id}}" selected>{{$site->name}}</option>
                                                                    @else
                                                                        <option value="{{$site->id}}">{{$site->name}}</option>
                                                                    @endif
                                                                @endforeach
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
                                                    <label for="country" class="col-md-3 col-form-label ml-sm-25 mr-sm-25 ml-xs-25 mr-xs-25 required">Country</label>
                                                    <div class="col-md-7 ml-sm-25 mr-sm-25 ml-xs-25 mr-xs-25">
                                                        <select class="form-control select2" name="country">
                                                            <option value="">Select Country</option>
                                                            @foreach($countries as $country)
                                                                @if($country->country_code == $account_list->country)
                                                                    <option value="{{$country->country_code}}" selected> {{$country->country_name}}</option>
                                                                @else
                                                                    <option value="{{$country->country_code}}"> {{$country->country_name}}</option>
                                                                @endif
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <div class="col-md-1"></div>
                                                    <label for="location" class="col-md-3 col-form-label ml-sm-25 mr-sm-25 ml-xs-25 mr-xs-25 required">Location</label>
                                                    <div class="col-md-7 ml-sm-25 mr-sm-25 ml-xs-25 mr-xs-25">
                                                        <input id="location" type="text" class="form-control @error('location') is-invalid @enderror" name="location" value="{{$account_list->location}}" maxlength="80" onkeyup="Count();" required autocomplete="location" autofocus>
                                                        <span id="location" class="float-right"></span>
                                                        @error('location')
                                                        <span class="invalid-feedback" role="alert">
                                             <strong>{{ $message }}</strong>
                                        </span>
                                                        @enderror
                                                    </div>
                                                </div>


                                                <div class="form-group row">
                                                    <div class="col-md-1"></div>
                                                    <label for="post_code" class="col-md-3 col-form-label ml-sm-25 mr-sm-25 ml-xs-25 mr-xs-25 required">Post code</label>
                                                    <div class="col-md-7 ml-sm-25 mr-sm-25 ml-xs-25 mr-xs-25">
                                                        <input id="post_code" type="text" class="form-control @error('post_code') is-invalid @enderror" name="post_code" value="{{$account_list->post_code}}" maxlength="80" onkeyup="Count();" required autocomplete="post_code" autofocus>
                                                        <span id="post_code" class="float-right"></span>
                                                        @error('post_code')
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
                                                        <input type="file" name="logo">
                                                        @error('developer_id')
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
                                            <form role="form" class="vendor-form mobile-responsive" action="{{URL::to('delete-ebay-account/'.$account_list->id)}}" method="post" enctype="multipart/form-data">
                                                @csrf



                                                <div class="form-group row">
                                                    <div class="col-md-1"></div>
                                                    <label for="category" class="col-md-3 col-form-label ml-sm-25 mr-sm-25 ml-xs-25 mr-xs-25 required">Delete Options</label>
                                                    <div class="col-md-7 ml-sm-25 mr-sm-25 ml-xs-25 mr-xs-25">
                                                        <select class="form-control select2 @error('delete_info') is-invalid @enderror" name="delete_info"  required  autofocus>
                                                            <option value="" disabled selected>Select Option</option>
                                                            <option value="1" >Delete Only WMS Listings</option>
                                                            @if(!$status[$account_list->id])
                                                                <option value="2" disabled>Delete Both WMS and eBay Listings</option>
                                                            @else
                                                                <option value="2">Delete Both WMS and eBay Listings</option>
                                                            @endif
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
                                                            <b>Update</b>
                                                        </button>
                                                    </div>
                                                </div>

                                            </form>
                                        </div>
{{--                                        account delete modal ends--}}




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
        <h4 class="custom-modal-title">Add eBay Account</h4>

        <form role="form" class="vendor-form mobile-responsive" action="{{URL::to('ebay-create-account/old')}}" method="post" enctype="multipart/form-data">
            @csrf

            <div class="form-group row">
                <div class="col-md-1"></div>
                <label for="name" class="col-md-3 col-form-label ml-sm-25 mr-sm-25 ml-xs-25 mr-xs-25 required">eBay Username</label>
                <div class="col-md-7 ml-sm-25 mr-sm-25 ml-xs-25 mr-xs-25">
                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="account_name" value="" maxlength="80" onkeyup="Count();" required autocomplete="name" autofocus>
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
                <div class="col-md-1"></div>
                <label for="feeder_quantity" class="col-md-3 col-form-label ml-sm-25 mr-sm-25 ml-xs-25 mr-xs-25 required">Feeder Quantity</label>
                <div class="col-md-7 ml-sm-25 mr-sm-25 ml-xs-25 mr-xs-25">
                    <input id="feeder_quantity" type="number" class="form-control @error('feeder_quantity') is-invalid @enderror" name="feeder_quantity"  maxlength="80" onkeyup="Count();" required autocomplete="name" autofocus>
                    <span id="display" class="float-right"></span>
                    @error('feeder_quantity')
                    <span class="invalid-feedback" role="alert">
                                                             <strong>{{ $message }}</strong>
                                                        </span>
                    @enderror
                </div>
                <div class="col-md-1"></div>
            </div>

            <div class="form-group row">
                <div class="col-md-1"></div>
                <label for="category" class="col-md-3 col-form-label ml-sm-25 mr-sm-25 ml-xs-25 mr-xs-25 required">eBay Site</label>
                <div class="col-md-7 ml-sm-25 mr-sm-25 ml-xs-25 mr-xs-25">
                    <select id="site_id" class="form-control select2 @error('site') is-invalid @enderror"  multiple="multiple" name="site_id[]" value="{{ old('site_id') }}" required autocomplete="site_id" autofocus>
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
                <label for="country" class="col-md-3 col-form-label ml-sm-25 mr-sm-25 ml-xs-25 mr-xs-25 required">Country</label>
                <div class="col-md-7 ml-sm-25 mr-sm-25 ml-xs-25 mr-xs-25">
                    <select class="form-control select2" name="country">
                        <option value="">Select Country</option>
                        @foreach($countries as $country)
                            <option value="{{$country->country_code}}">{{$country->country_name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form-group row">
                <div class="col-md-1"></div>
                <label for="location" class="col-md-3 col-form-label ml-sm-25 mr-sm-25 ml-xs-25 mr-xs-25 required">Item Location</label>
                <div class="col-md-7 ml-sm-25 mr-sm-25 ml-xs-25 mr-xs-25">
                    <input id="location" type="text" class="form-control @error('location') is-invalid @enderror" name="location" value="" maxlength="80" onkeyup="Count();" required autocomplete="location" autofocus>
                    <span id="location" class="float-right"></span>
                    @error('location')
                    <span class="invalid-feedback" role="alert">
                                             <strong>{{ $message }}</strong>
                                        </span>
                    @enderror
                </div>
            </div>

            <div class="form-group row">
                <div class="col-md-1"></div>
                <label for="category" class="col-md-3 col-form-label ml-sm-25 mr-sm-25 ml-xs-25 mr-xs-25 required">Developer Account</label>
                <div class="col-md-7 ml-sm-25 mr-sm-25 ml-xs-25 mr-xs-25">
                    <select id="developer_id" class="form-control select2 @error('developer_id') is-invalid @enderror"  name="developer_id" value="{{ old('developer_id') }}" required autocomplete="developer_id" autofocus>
                        @foreach($developer_accounts as $developer_account)
                            <option value="{{$developer_account->id}}">{{$developer_account->client_id}}</option>
                        @endforeach
                    </select>
                    @error('developer_id')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="col-md-1"></div>
            </div>

            <div class="form-group row">
                <div class="col-md-1"></div>
                <label for="post_code" class="col-md-3 col-form-label ml-sm-25 mr-sm-25 ml-xs-25 mr-xs-25 required">Postcode</label>
                <div class="col-md-7 ml-sm-25 mr-sm-25 ml-xs-25 mr-xs-25">
                    <input id="post_code" type="text" class="form-control @error('post_code') is-invalid @enderror" name="post_code" value="" maxlength="80" onkeyup="Count();" required autocomplete="post_code" autofocus>
                    <span id="post_code" class="float-right"></span>
                    @error('post_code')
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
                    <input type="file" name="logo">
                    @error('developer_id')
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
        function openAndSave(account_id){

            // return false;
            //var  account_id = document.querySelector('input[name=account_id]').value;
            var site_id = document.querySelector('input[name=site_id]').value;
            // var sign_in_link = document.querySelector('input[name=sign_in_link]').value;
            // window.open(sign_in_link,'popUpWindow','height=400,width=600,left=10,top=10,,scrollbars=yes,menubar=no');
            // console.log(account_id)
            // console.log(site_id)
            let url = window.location.href;

            const url_array = url.split("ebay-account-list");
            Cookies.set('url', url_array[0]);
            Cookies.set('account_id', account_id);
            // Cookies.set('site_id', site_id);
            Cookies.set('type', 'old');

            {{--$.ajax({--}}
            {{--    type : "post",--}}
            {{--    url : "{{URL::to('save-authorization')}}",--}}
            {{--    data : {--}}
            {{--        "_token" : "{{csrf_token()}}",--}}
            {{--        "account_id":account_id,--}}
            {{--        "site_id" : site_id,--}}
            {{--    },--}}
            {{--    beforeSend: function (){--}}
            {{--        $("#Load").show();--}}
            {{--    },--}}
            {{--    success : function (response){--}}
            {{--        // alert("Authorization complete! ");--}}
            {{--        // var d = new Date();--}}
            {{--        // d.setTime(d.getTime() + (30*24*60*60*1000));--}}
            {{--        // var expires = "expires=" + d.toGMTString();--}}
            {{--        // document.cookie = "token_auth=" + ";" + expires + ";path=/";--}}
            {{--        // console.log(get('url'))--}}

            {{--    },--}}
            {{--    complete:function(data){--}}
            {{--        // Hide image container--}}
            {{--        $("#Load").hide();--}}
            {{--    }--}}
            {{--})--}}
            {{--return false;--}}

        }
        function get(name){
            if(name=(new RegExp('[?&]'+encodeURIComponent(name)+'=([^&]*)')).exec(location.search))
                return decodeURIComponent(name[1]);
        }
        function getMigration(accountId){
            console.log(accountId)
            $.ajax({
                type: "get",
                url: "{{url('ebay-sync-account')}}"+'/'+accountId+'/old',
                beforeSend: function (){
                    $("#"+"a"+accountId).removeClass("fas fa-sync");
                    $("#"+"a"+accountId).addClass("fa fa-circle-o-notch fa-spin");
                    // document.getElementById("a"+accountId).classList.replace("fa fa-circle-o-notch fa-spin")
                    // $('#Load').show();
                },
                success: function (response) {
                    console.log(response)
                    $("#"+"a"+accountId).removeClass("fa fa-circle-o-notch fa-spin");
                    $("#"+"a"+accountId).addClass("fas fa-sync");
                    // $('#Load').hide();
                },
                complete: function (data) {
                    $("#"+"a"+accountId).removeClass("fa fa-circle-o-notch fa-spin");
                    $("#"+"a"+accountId).addClass("fas fa-sync");
                    // $('#Load').hide();
                }
            });
        }
        $('.select2').select2();
    </script>



@endsection
