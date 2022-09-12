
@extends('master')

@section('title')
    Woocommerce | Account | WMS 360
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
                        <li class="breadcrumb-item">WooCommerce</li>
                        <li class="breadcrumb-item active" aria-current="page">Account List</li>
                    </ol>
                    @if(count($account_details) == 0)
                        <div class="breadcrumbRightSideBtn">
                            <a href="#addAccount" data-animation="slit" data-plugin="custommodal" data-overlaySpeed="100" data-overlayColor="#36404a"><button class="btn btn-default waves-effect waves-light"> Add Account </button></a>
                        </div>
                    @endif
                </div>


                <div class="row m-t-20">
                    <div class="col-md-12">
                        <div class="card-box onbuy table-responsive shadow">
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
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

                            <table class="onbuy-table w-100 table-primary-btm">
                                <thead>
                                <tr>
                                    <th>Consumer Key</th>
                                    <th>Secret Key</th>
                                    <th>Site Url</th>
                                    <th>Status</th>
                                    <th>Creator</th>
                                    <th>Modifier</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if(count($account_details) > 0)
                                    @foreach($account_details as $account)
                                        <tr class="p-2">
                                            <td>{{$account->consumer_key ?? ''}}</td>
                                            <td>{{$account->secret_key ?? ''}}</td>
                                            <td>{{$account->site_url ?? ''}}</td>
                                            <td>{{($account->status == 1) ? 'Active' : 'Inactive'}}</td>
                                            <td>{{$account->creatorInfo->name ?? ''}}</td>
                                            <td>{{$account->modifierInfo->name ?? ''}}</td>
                                            <td>
                                                <div class="d-flex justify-content-start">
                                                    <div class="mr-2">
                                                        <a class="btn-size edit-btn"  href="#editAccountList{{$account->id ?? ''}}" data-animation="slit" data-plugin="custommodal" data-overlaySpeed="100" data-overlayColor="#36404a" data-placement="top" title="Edit"><i class="fa fa-edit" aria-hidden="true"></i></a>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>

                                        <!-- Edit OnBuy account Modal -->
                                        <div id="editAccountList{{$account->id ?? ''}}" class="modal-demo">
                                            <button type="button" class="close" onclick="Custombox.close();">
                                                <span>&times;</span><span class="sr-only">Close</span>
                                            </button>
                                            <h4 class="custom-modal-title">Edit Account</h4>
                                            <form role="form" class="vendor-form mobile-responsive" action="{{url('woocommerce/update-account/'.$account->id ?? '')}}" method="post">
                                                @csrf
                                                <div class="form-group row">
                                                    <div class="col-md-1"></div>
                                                    <label for="name" class="col-md-3 col-form-label ml-sm-25 mr-sm-25 ml-xs-25 mr-xs-25 required">Consumer Key</label>
                                                    <div class="col-md-7 ml-sm-25 mr-sm-25 ml-xs-25 mr-xs-25">
                                                        <input id="consumer_key" type="text" class="form-control" name="consumer_key" value="{{$account->consumer_key ?? ''}}" maxlength="80" required autocomplete="consumer_key" autofocus>
                                                    </div>
                                                    <div class="col-md-1"></div>
                                                </div>

                                                <div class="form-group row">
                                                    <div class="col-md-1"></div>
                                                    <label for="name" class="col-md-3 col-form-label ml-sm-25 mr-sm-25 ml-xs-25 mr-xs-25 required">Secret Key</label>
                                                    <div class="col-md-7 ml-sm-25 mr-sm-25 ml-xs-25 mr-xs-25">
                                                        <input id="secret_key" type="text" class="form-control" name="secret_key" value="{{$account->secret_key ?? ''}}" required autocomplete="secret_key" autofocus>
                                                    </div>
                                                    <div class="col-md-1"></div>
                                                </div>

                                                <div class="form-group row">
                                                    <div class="col-md-1"></div>
                                                    <label for="name" class="col-md-3 col-form-label ml-sm-25 mr-sm-25 ml-xs-25 mr-xs-25 required">Site Url</label>
                                                    <div class="col-md-7 ml-sm-25 mr-sm-25 ml-xs-25 mr-xs-25">
                                                        <input id="site_url" type="text" class="form-control" name="site_url" value="{{$account->site_url ?? ''}}" required autocomplete="site_url" autofocus>
                                                    </div>
                                                    <div class="col-md-1"></div>
                                                </div>

                                                <div class="form-group row">
                                                    <div class="col-md-1"></div>
                                                    <label for="status" class="col-md-3 col-form-label ml-sm-25 mr-sm-25 ml-xs-25 mr-xs-25 required">Status</label>
                                                    <div class="col-md-7 ml-sm-25 mr-sm-25 ml-xs-25 mr-xs-25">
                                                        <select class="form-control" name="status" id="status" required>
                                                            <option value="1" @if($account->status == 1) selected @endif>Active</option>
                                                            <option value="0" @if($account->status == 0) selected @endif>Inactive</option>
                                                        </select>
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
                                    @endforeach
                                @endif
                                <!--End Edit OnBuy account Modal -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div> <!-- end row -->
            </div> <!-- container -->
        </div> <!-- content -->

    </div>   <!-- content page -->


    <!-- Add OnBuy Account Modal -->
    <div id="addAccount" class="modal-demo">
        <button type="button" class="close" onclick="Custombox.close();">
            <span>&times;</span><span class="sr-only">Close</span>
        </button>
        <h4 class="custom-modal-title">Add Account</h4>

        <form role="form" class="vendor-form mobile-responsive" action="{{url('woocommerce/create-account')}}" method="post">
            @csrf

            <div class="form-group row">
                <div class="col-md-1"></div>
                <label for="name" class="col-md-3 col-form-label ml-sm-25 mr-sm-25 ml-xs-25 mr-xs-25 required">Consumer Key</label>
                <div class="col-md-7 ml-sm-25 mr-sm-25 ml-xs-25 mr-xs-25">
                    <input id="consumer_key" type="text" class="form-control" name="consumer_key" value="" maxlength="80" required autocomplete="consumer_key" autofocus>
                </div>
                <div class="col-md-1"></div>
            </div>

            <div class="form-group row">
                <div class="col-md-1"></div>
                <label for="name" class="col-md-3 col-form-label ml-sm-25 mr-sm-25 ml-xs-25 mr-xs-25 required">Secret Key</label>
                <div class="col-md-7 ml-sm-25 mr-sm-25 ml-xs-25 mr-xs-25">
                    <input id="secret_key" type="text" class="form-control" name="secret_key" value="" required autocomplete="secret_key" autofocus>
                </div>
                <div class="col-md-1"></div>
            </div>

            <div class="form-group row">
                <div class="col-md-1"></div>
                <label for="name" class="col-md-3 col-form-label ml-sm-25 mr-sm-25 ml-xs-25 mr-xs-25 required">Site Url</label>
                <div class="col-md-7 ml-sm-25 mr-sm-25 ml-xs-25 mr-xs-25">
                    <input id="site_url" type="text" class="form-control" name="site_url" value="" required autocomplete="site_url" autofocus>
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
    <!--End OnBuy account Modal -->




@endsection
