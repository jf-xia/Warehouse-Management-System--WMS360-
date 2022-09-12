@extends('master')
@section('title')
    Settings | WMS360
@endsection
@section('content')
    <div class="content-page">
        <!-- Start content -->
        <div class="content" >
            <div class="container-fluid">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <ol class="breadcrumb page-breadcrumb">
                            <li class="breadcrumb-item" aria-current="page">Setting</li>
                            <li class="breadcrumb-item active" aria-current="page">Wms Settings</li>
                        </ol>
                    </div>
                </div>

                <div class="row m-t-20">
                    <div class="col-md-12">
                        <div class="card-box shadow">
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


                            <div class="container" >
                                <div class="card p-20 m-t-10 variation-card">
                                    <div class="col-md-6">
                                        <div class="msg-alert">
                                        </div>
                                        <div class=""> <strong>Your Information About App</strong></div>
                                        <div class="msg"></div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <span>ID</span>
                                                </div>
                                                <div class="col-md-2">
                                                    <span>:</span>
                                                </div>
                                                <div class="col-md-7">
                                                    <span>{{$client_info->client_id ?? ''}}</span><br>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <span>Name</span>
                                                </div>
                                                <div class="col-md-2">
                                                    <span>:</span>
                                                </div>
                                                <div class="col-md-7">
                                                    <span>{{$client_info->client_name ?? ''}}</span><br>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <span>App API URL</span>
                                                </div>
                                                <div class="col-md-2">
                                                    <span>:</span>
                                                </div>
                                                <div class="col-md-7">
                                                    <span>{{$client_info->url ?? ''}}</span><br>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <span>App Logo</span>
                                                </div>
                                                <div class="col-md-2">
                                                    <span>: </span>
                                                </div>
                                                <div class="col-md-7">
                                                    <span><img src="{{$client_info->logo_url ?? '#'}}" alt="logo" style="width: 100px;height: 100px;border: 1px solid #e1d0d0">
                                                        <button class="btn btn-primary" data-toggle="modal" data-target="#updateFormModal">Change</button>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <span>Listing Max</span>
                                                </div>
                                                <div class="col-md-2">
                                                    <span>: </span>
                                                </div>
                                                <div class="col-md-7">
                                                    <span>{{$client_info->listing_max ?? ''}}</span><br>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <span>Shelf Use</span>
                                                </div>
                                                <div class="col-md-2">
                                                    <span>: </span>
                                                </div>
                                                <div class="col-md-7">
                                                    <span>{{($client_info->shelf_use == 1) ? 'Yes' : 'No'}}</span><br>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <span>Payment Status</span>
                                                </div>
                                                <div class="col-md-2">
                                                    <span>:</span>
                                                </div>
                                                <div class="col-md-7">
                                                    <span>{{($client_info->payment_status == 1) ? 'Paid' : 'Unpaid'}}</span><br>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <span>Active Status</span>
                                                </div>
                                                <div class="col-md-2">
                                                    <span>:</span>
                                                </div>
                                                <div class="col-md-7">
                                                    <span>{{($client_info->status == 1) ? 'Active' : 'Inactive'}}</span><br>
                                                </div>
                                            </div>
                                            <div class="" style="margin-top:10px; margin-bottom:10px;"> <strong>Company Information</strong></div>
                                            <div class="" style="margin-top:10px; margin-bottom:10px;"> <strong>Address</strong></div>

                                            <form id="upload-logo-image" action="{{url('client/'.$client_info->id)}}" method="post" enctype="multipart/form-data">
                                            @csrf
                                            <input type="hidden" name="id" value="{{$client_info->client_id}}">

                                            <div class="row" style="margin-bottom:15px;">
                                                <div class="col-md-3" style="padding:0;">
                                                    <span>Address Line 1</span>
                                                </div>
                                                <div class="col-md-2">
                                                    <span>:</span>
                                                </div>
                                                <div class="col-md-7" style="padding:0;">
                                                <input type="text" name="address_line_1" class="form-control" id="address_line_1" value="{{$client_info->address_line_1 ?? ''}}" placeholder="Enter Address">
                                                </div>
                                            </div>
                                            <div class="row" style="margin-bottom:15px;">
                                                <div class="col-md-3" style="padding:0;">
                                                    <span>Address Line 2</span>
                                                </div>
                                                <div class="col-md-2">
                                                    <span>:</span>
                                                </div>
                                                <div class="col-md-7" style="padding:0;">
                                                <input type="text" name="address_line_2" class="form-control" id="address_line_2" value="{{$client_info->address_line_2 ?? ''}}" placeholder="Enter Address line 2">
                                                </div>
                                            </div>
                                            <div class="row" style="margin-bottom:15px;">
                                                <div class="col-md-3" style="padding:0;">
                                                    <span>Address Line 3</span>
                                                </div>
                                                <div class="col-md-2">
                                                    <span>:</span>
                                                </div>
                                                <div class="col-md-7" style="padding:0;">
                                                <input type="text" name="address_line_3" class="form-control" id="address_line_3" value="{{$client_info->address_line_3 ?? ''}}" placeholder="Enter Address line 3">
                                                </div>
                                            </div>
                                            <div class="row" style="margin-bottom:15px;">
                                                <div class="col-md-3" style="padding:0;">
                                                    <span>Country</span>
                                                </div>
                                                <div class="col-md-2">
                                                    <span>:</span>
                                                </div>
                                                <div class="col-md-7" style="padding:0;">
                                                <input type="text" name="country" class="form-control" id="country" value="{{$client_info->country ?? ''}}" placeholder="Enter Address line 3">
                                                </div>
                                            </div>
                                            <div class="row" style="margin-bottom:15px;">
                                                <div class="col-md-3" style="padding:0;">
                                                    <span>City</span>
                                                </div>
                                                <div class="col-md-2">
                                                    <span>:</span>
                                                </div>
                                                <div class="col-md-7" style="padding:0;">
                                                <input type="text" name="city" class="form-control" id="city" value="{{$client_info->city ?? ''}}" placeholder="Enter City">
                                                </div>
                                            </div>
                                            <div class="row" style="margin-bottom:15px;">
                                                <div class="col-md-3" style="padding:0;">
                                                    <span>Post Code</span>
                                                </div>
                                                <div class="col-md-2">
                                                    <span>:</span>
                                                </div>
                                                <div class="col-md-7" style="padding:0;">
                                                <input type="text" name="post_code" class="form-control" id="post_code" value="{{$client_info->post_code ?? ''}}" placeholder="Enter Post Code">
                                                </div>
                                            </div>
                                            <div class="row" style="margin-bottom:15px;">
                                                <div class="col-md-3" style="padding:0;">
                                                    <span>Phone Number</span>
                                                </div>
                                                <div class="col-md-2">
                                                    <span>:</span>
                                                </div>
                                                <div class="col-md-7" style="padding:0;">
                                                <input type="text" name="phone_no" class="form-control" id="phone_no" value="{{$client_info->phone_no ?? ''}}" placeholder="Enter Phone Number">
                                                </div>
                                            </div>
                                            <div class="row" style="margin-bottom:15px;">
                                                <div class="col-md-3" style="padding:0;">
                                                    <span>Registration Number</span>
                                                </div>
                                                <div class="col-md-2">
                                                    <span>:</span>
                                                </div>
                                                <div class="col-md-7" style="padding:0;">
                                                <input type="text" name="reg_no" class="form-control" id="reg_no" value="{{$client_info->reg_no ?? ''}}" placeholder="Enter Registration Number">
                                                </div>
                                            </div>
                                            <div class="row" style="margin-bottom:15px;">
                                                <div class="col-md-3" style="padding:0;">
                                                    <span>Email</span>
                                                </div>
                                                <div class="col-md-2">
                                                    <span>:</span>
                                                </div>
                                                <div class="col-md-7" style="padding:0;">
                                                <input type="text" name="email" class="form-control" id="email" value="{{$client_info->email ?? ''}}" placeholder="Enter Email">
                                                </div>
                                            </div>
                                            <div class="row" style="margin-bottom:15px;">
                                                <div class="col-md-3" style="padding:0;">
                                                    <span>Vat ID</span>
                                                </div>
                                                <div class="col-md-2">
                                                    <span>:</span>
                                                </div>
                                                <div class="col-md-7" style="padding:0;">
                                                <input type="text" name="vat" class="form-control" id="vat" value="{{$client_info->vat ?? ''}}" placeholder="Enter Vat">
                                                </div>
                                            </div>
                                            <div class="row" style="margin-bottom:15px; text-align:center;">
                                                <div class="col-md-12" style="padding:0;">
                                                <button style="width:200px; margin-top:20px;" type="submit" class="btn btn-primary save-logo-url">Save Info</button>
                                                </div>
                                            </div>
                                        </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Modal -->
                            <div class="modal fade" id="updateFormModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <form id="upload-logo-image" action="{{url('client')}}" method="post" enctype="multipart/form-data">
                                        @csrf
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">App Logo</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="col-md-2">Logo :</div>
                                                    <div class="col-md-6">
                                                        <input type="file" name="logo_url" id="logo_url" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-primary save-logo-url">Save changes</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>


                            <form id="chargeForm" class="m-t-40 mobile-responsive" role="form" action="#"  method="post">
                                <div class="container" >
                                    <div class="card p-20 m-t-10 variation-card">
                                        <div class="form-group row">
                                            <div class="col-md-6">
                                                <div class="msg-alert">
                                                </div>
                                                <div class=""> <label>Do you want to use shelf ?</label></div>
                                                <div>
                                                    <input type="radio" name="shelf_status" class="form-control" id="shelf_status" value="1" @if($client_info->shelf_use == 1) checked @endif> Yes
                                                </div>
                                                <div>
                                                    <input type="radio" name="shelf_status" class="form-control" id="shelf_status" value="0" @if($client_info->shelf_use == 0) checked @endif> No
                                                </div>
                                            </div>
                                        </div>
                                        <!--form-group end-->
                                        <span>
                                            <button type="button" class="btn btn-primary add_shelf_status float-left">Apply</button>
                                        </span>
                                    </div>
                                </div>
                            </form> <!--END FORM-->

                            <div class="container m-t-20">
                                <div class="card p-20">
                                   <h5>Order Combined Settings</h5>
                                   <form action="{{url('/save-combined-order-setting')}}" method="POST">
                                       @csrf
                                        <div class="form-check">
                                            <input type="checkbox" name="filter_order[user_id]" @if(isset($unserializeCombinedOrderSettingInfo['order']['combined_order']['user_id'])) checked @endif class="form-check-input" id="user_id">
                                            <label class="form-check-label" for="user_id">User Id</label>
                                        </div>
                                        <div class="form-check">
                                            <input type="checkbox" name="filter_order[customer_name]" @if(isset($unserializeCombinedOrderSettingInfo['order']['combined_order']['customer_name'])) checked @endif class="form-check-input" id="customer_name">
                                            <label class="form-check-label" for="customer_name">Customer Name</label>
                                        </div>
                                        <div class="form-check">
                                            <input type="checkbox" name="filter_order[1st_line_address]" @if(isset($unserializeCombinedOrderSettingInfo['order']['combined_order']['1st_line_address'])) checked @endif class="form-check-input" id="1st_line_address">
                                            <label class="form-check-label" for="1st_line_address">1st Line Address</label>
                                        </div>
                                        <div class="form-check">
                                            <input type="checkbox" name="filter_order[postcode]" @if(isset($unserializeCombinedOrderSettingInfo['order']['combined_order']['postcode'])) checked @endif class="form-check-input" id="postcode">
                                            <label class="form-check-label" for="postcode">Postcode</label>
                                        </div>
                                        <div class="form-check">
                                            <input type="checkbox" name="filter_order[channel]" @if(isset($unserializeCombinedOrderSettingInfo['order']['combined_order']['channel'])) checked @endif class="form-check-input" id="channel">
                                            <label class="form-check-label" for="channel">Channel</label>
                                        </div>
                                        <div>
                                            <button type="submit" class="btn btn-primary mt-3">Save</button>
                                        </div>
                                    </form>
                                   <!-- <input type="checkbox" class="form-control" name="filter_order_setting" value="1"> User Id -->
                                </div>
                            </div>
                        </div>  <!-- card-box -->
                    </div> <!-- end col -->
                </div>
                <!-- end row -->
            </div> <!-- container -->
        </div> <!-- content -->
    </div>  <!-- content page -->

    <script type="text/javascript">
        jQuery(document).ready(function(){
            $('.summernote').summernote({
                height: 250,                 // set editor height
                minHeight: null,             // set minimum height of editor
                maxHeight: null,             // set maximum height of editor
                focus: false                 // set focus to editable area after initializing summernote
            });

            $('.inline-editor').summernote({
                airMode: true
            });

            $('button.add_shelf_status').on('click',function () {
                var shelfStatus = $('input[name=shelf_status]:checked').val();
                $.ajax({
                    type: "GET",
                    url: "{{url('shelf-use-setting')}}" + '/' + shelfStatus,
                    success: function (response){
                        $('div.msg-alert').addClass('alert alert-success').html(response);
                    }
                })
            });
        });
    </script>
@endsection
