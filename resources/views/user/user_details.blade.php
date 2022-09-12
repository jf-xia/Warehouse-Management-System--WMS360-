@extends('master')

@section('title')
    User | User Profile | WMS360
@endsection

@section('content')

    <div class="content-page">
        <!-- Start content -->
        <div class="content">
            <div class="container-fluid">


                <div class="d-flex justify-content-center align-items-center">
                    <ol class="breadcrumb page-breadcrumb">
                        <li class="breadcrumb-item" aria-current="page"><a href="{{url('user-list')}}">User</a></li>
                        <li class="breadcrumb-item active" aria-current="page">User Profile</li>
                    </ol>
                </div>


                <?php
                $data = '';
                foreach ($single_user->roles as $user){
                    $data .= $user->role_name.', ';
                }
                ?>


                <div class="profile-background-image-body m-t-20">
                    <div class="text-center">
                        <div>
                            <img class="rounded-circle mt-4" src="{{asset($single_user->image ? 'uploads/'.$single_user->image : 'assets/common-assets/img_avatar.png')}}" width="150" height="150" alt="Profile image">
{{--                            <img class="rounded-circle mt-4" src="{{asset('assets/images/avatar-1.jpg')}}" alt="Profile-Image" width="150">--}}
                        </div>
                        <div class="p-b-10">
                            <h2 class="text-white">{{$single_user->name ?? ''}}</h2>
                            <h5 class="text-white">{{rtrim($data,', ')}}</h5>
                        </div>
{{--                        <div style="padding-bottom: 20px">--}}
{{--                            <div class="mb-2 mt-3">--}}
{{--                                <h6 class="text-white">Follow Solaiman Hoosain On</h6>--}}
{{--                            </div>--}}
{{--                            <a href="#" class="btn btn-social-icon mr-1 btn-facebook">--}}
{{--                                <i class="fa fa-facebook-f"></i>--}}
{{--                            </a>--}}
{{--                            <a href="#" class="btn btn-social-icon mr-1 btn-twitter">--}}
{{--                                <i class="fa fa-twitter"></i>--}}
{{--                            </a>--}}
{{--                            <a href="#" class="btn btn-social-icon mr-1 btn-instagram">--}}
{{--                                <i class="fa fa-instagram"></i>--}}
{{--                            </a>--}}
{{--                            <div class="w-100 d-sm-none"></div>--}}
{{--                        </div>--}}
                    </div>
                </div>


                <div class="row m-t-20 m-b-20">
                    <div class="col-md-4">
                        <div class="card-box">

                            <div class="card-header personal-details-card-header">
                                <h4>Personal Details</h4>
                            </div>
                            <div class="card-body pb-0">
                                <p class="clearfix mb-3">
                                    <span class="float-left">
                                      Employee ID
                                    </span>
                                    <span class="float-right text-muted">
                                    {{$single_user->employee_id}}
                                    </span>
                                </p>
                                <p class="clearfix mb-3">
                                    <span class="float-left">
                                      Address
                                    </span>
                                    <span class="float-right text-muted">
                                      {{$single_user->address}}
                                    </span>
                                </p>
                                {{-- <p class="clearfix mb-3">
                                    <span class="float-left">
                                     Live In
                                    </span>
                                    <span class="float-right text-muted">
                                      {{$single_user->city}}
                                    </span>
                                </p> --}}
                                <p class="clearfix mb-3">
                                    <span class="float-left">
                                     State
                                    </span>
                                    <span class="float-right text-muted">
                                      {{$single_user->state}}
                                    </span>
                                </p>
                                <p class="clearfix mb-3">
                                    <span class="float-left">
                                      Country
                                    </span>
                                    <span class="float-right text-muted">
                                      {{$single_user->country}}
                                    </span>
                                </p>
                                <p class="clearfix mb-3">
                                    <span class="float-left">
                                     Postcode
                                    </span>
                                    <span class="float-right text-muted">
                                        {{$single_user->zip_code}}
                                    </span>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="card-box">

                            @if ($message = Session::get('password_success_msg'))
                                <div class="alert alert-success alert-block">
                                    <button type="button" class="close" data-dismiss="alert">×</button>
                                    <strong>{{ $message }}</strong>
                                </div>
                            @endif

                            @if ($message = Session::get('user_update_success_msg'))
                                <div class="alert alert-success alert-block">
                                    <button type="button" class="close" data-dismiss="alert">×</button>
                                    <strong>{{ $message }}</strong>
                                </div>
                            @endif

                            @if ($message = Session::get('password_not_match_msg'))
                                <div class="alert alert-danger alert-block">
                                    <button type="button" class="close" data-dismiss="alert">×</button>
                                    <strong>{{ $message }}</strong>
                                </div>
                            @endif    

                            <ul class="nav nav-tabs profile-nav-tabs tabs">
                                <li class="active tab">
                                    <a href="#about" data-toggle="tab" aria-expanded="false">
                                        About
                                    </a>
                                </li>
                                <li class="tab">
                                    <a href="#edit-profile" data-toggle="tab" aria-expanded="false">
                                        Edit Profile
                                    </a>
                                </li>
                                <li class="tab">
                                    <a href="#reset-password" data-toggle="tab" aria-expanded="false">
                                        Reset Password   
                                    </a>
                                </li>
                            </ul>
                            <div class="tab-content profile-tab-content mb-0">
                                <div class="tab-pane active" id="about">
                                    <div class="row">
                                        <div class="col-md-3 col-sm-6 b-r">
                                            <strong>Name</strong>
                                            <br>
                                            <p class="text-muted mt-1">{{$single_user->name ?? ''}}</p>
                                        </div>
                                        <div class="col-md-3 col-sm-6 b-r">
                                            <strong>Email</strong>
                                            <br>
                                            <p class="text-muted mt-1">{{$single_user->email}}</p>
                                        </div>
                                        <div class="col-md-3 col-sm-6 b-r">
                                            <strong>Phone</strong>
                                            <br>
                                            <p class="text-muted mt-1">{{$single_user->phone_no}}</p>
                                        </div>
                                        <div class="col-md-3 col-sm-6">
                                            <strong>Location</strong>
                                            <br>
                                            <p class="text-muted mt-1">{{$single_user->country}}</p>
                                        </div>
                                    </div>
                                </div>


                                <div class="tab-pane" id="edit-profile">
                                    <form role="form" method="POST" action="{{url('update-user/'.$single_user->id)}}" enctype="multipart/form-data">
                                        @csrf
{{--                                            <div class="card-header">--}}
{{--                                                <h4>Edit Profile</h4>--}}
{{--                                            </div>--}}

                                        <div class="form-group row">
                                            <label for="image" class="col-md-3 col-form-label">Select Image</label>
                                            <div class="col-md-9">
                                                <div class="custom-file m-b-10">
                                                    <input type="file" class="custom-file-input" id="imgInp" name="user_image">
                                                    <label class="custom-file-label" for="customFile">Choose image</label>
                                                </div>
                                                <img class="rounded" id="user_edit_image" src="{{asset($single_user->image ? 'uploads/'.$single_user->image : 'assets/common-assets/img_avatar.png')}}" alt="Image" width="150px" height="auto">
{{--                                                <img class="rounded-circle" src="{{asset('assets/images/avatar-1.jpg')}}" alt="Profile-Image">--}}
                                                <img id="blah" class="rounded" src="#" alt="Images" width="150px" height="120px" style="display: none;">
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="form-group col-md-6 col-12">
                                                <label for="name" class="required">First Name</label>
                                                <input type="text" name="name" class="form-control" id="name" value="{{$single_user->name ? $single_user->name : old('name')}}" required>
                                            </div>
                                            <div class="form-group col-md-6 col-12">
                                                <label for="last_name" class="required">Last Name</label>
                                                <input type="text" name="last_name" class="form-control" id="last_name" value="{{$single_user->last_name ? $single_user->last_name : old('last_name')}}" required>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="form-group col-md-6 col-12">
                                                <label for="email" class="required">Email</label>
                                                <input type="email" name="email" class="form-control" id="email" value="{{$single_user->email ? $single_user->email : old('email')}}" required>
                                            </div>
                                            <div class="form-group col-md-6 col-12">
                                                <label for="employee_id">Employee Id</label>
                                                <input type="text" name="employee_id" class="form-control" id="employee_id" value="{{$single_user->employee_id ? $single_user->employee_id : old('employee_id')}}">
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="form-group col-md-6">
                                                <label for="role" class="required">Role </label>
                                                <div class="profile-checkbox d-flex justify-content-lg-left mt-1">
                                                    <div class="wms-row user-row">
                                                        @foreach($all_role as $role)
                                                            <?php
                                                            $temp = '';
                                                            ?>
                                                            @foreach($single_user->roles as $roles)
                                                                @if($role->id == $roles->id)
                                                                    <div class="wms-col-4 user-checkbox">
                                                                        <input type="checkbox" name="role[]" value="{{$roles->id}}" checked>&nbsp;{{$roles->role_name}}
                                                                    </div>
                                                                    <?php
                                                                    $temp = 1;
                                                                    ?>
                                                                @endif
                                                            @endforeach
                                                            @if($temp == null)
                                                                <input type="checkbox" name="role[]" value="{{$role->id}}">{{$role->role_name}}
                                                            @endif
                                                        @endforeach
                                                    </div>

                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="form-group col-md-6 col-12">
                                                <label for="phone_no" class="required">Phone Number</label>
                                                <input type="text" name="phone_no" class="form-control" id="phone_no" value="{{$single_user->phone_no ? $single_user->phone_no : old('phone_no')}}">
                                            </div>
                                            <div class="form-group col-md-6 col-12">
                                                <label for="card_no">Card Number </label>
                                                <input type="text" name="card_no" class="form-control" id="card_no" value="{{$single_user->card_no ? $single_user->card_no : old('card_no')}}">
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="form-group col-md-6 col-12">
                                                <label for="city">City</label>
                                                <input type="text" name="city" class="form-control" id="city" value="{{$single_user->city ? $single_user->city : old('city')}}">
                                            </div>
                                            <div class="form-group col-md-6 col-12">
                                                <label for="state">State</label>
                                                <input type="text" name="state" class="form-control" id="state" value="{{$single_user->state ? $single_user->country : old('state')}}">
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="form-group col-md-6 col-12">
                                                <label for="country">Country</label>
                                                <input type="text" name="country" class="form-control" id="country" value="{{$single_user->country ? $single_user->country : old('country')}}">
                                            </div>
                                            <div class="form-group col-md-6 col-12">
                                                <label for="zip_code">Zip Code</label>
                                                <input type="text" name="zip_code" class="form-control" id="zip_code" value="{{$single_user->zip_code ? $single_user->zip_code : old('zip_code')}}">
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="form-group col-md-6 col-12">
                                                <label for="address">Address </label>
                                                <textarea name="address" class="form-control" id="address" value="" placeholder="Enter Addreess">{{$single_user->address ? $single_user->address : old('address')}}
                                                </textarea>
                                            </div>
                                        </div>

                                        <input type="hidden" name="exist_image" value="{{$single_user->image}}">

                                        <div class="form-group row vendor-btn-top">
                                            <div class="col-md-12 text-center">
                                                <button type="submit" class="btn btn-primary vendor-btn waves-effect waves-light">
                                                    <b> Update </b>
                                                </button>
                                            </div>
                                        </div>

                                    </form>
                                </div>

                                <div class="tab-pane" id="reset-password">
                                    <form role="form" class="mobile-responsive" action="{{url('user/update-password')}}" method="post" data-parsley-validate>
                                        @csrf
                                        <div class="form-group row">
                                            <div class="col-md-1"></div>
                                            <label for="name" class="col-md-3 col-form-label">Current Password</label>
                                            <div class="col-md-7">
                                                <input type="password" name="old_password" class="form-control" id="old_password" value="" placeholder="Enter Current password" required>
                                            </div>
                                            <div class="col-md-1"></div>
                                        </div>
        
                                        <div class="form-group row">
                                            <div class="col-md-1"></div>
                                            <label for="name" class="col-md-3 col-form-label">New Password</label>
                                            <div class="col-md-7">
                                                <input type="password" name="password" class="form-control" id="password" value="" placeholder="Enter new password" data-parsley-length="[8,16]" data-parsley-trigger="keyup" data-parsley-required >
                                            </div>
                                            <div class="col-md-1"></div>
                                        </div>
        
                                        <div class="form-group row">
                                            <div class="col-md-1"></div>
                                            <label for="name" class="col-md-3 col-form-label">Confirm Password</label>
                                            <div class="col-md-7">
                                                <input type="password" name="password_confirmation" class="form-control" id="password_confirmation" value="" placeholder="Enter confirm password" data-parsley-equalto="#password" data-parsley-trigger="keyup" data-parsley-required >
                                            </div>
                                            <div class="col-md-1"></div>
                                        </div>
        
                                        <input type="hidden" name="user_id" value="{{$id}}">
        
                                        <div class="form-group row vendor-btn-top">
                                            <div class="col-md-12 text-center">
                                                <button type="submit" class="btn btn-primary vendor-btn waves-effect waves-light">
                                                    <b>Update</b>
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>


                <!-- Page-Title -->
{{--                <div class="row">--}}
{{--                    <div class="col-md-12 text-center">--}}
{{--                        <div class="bg-white pt-3 pb-3">--}}
{{--                            <a href="{{url('edit-user/'.Crypt::encrypt($single_user->id))}}" class="vendor-btn">Update Profile</a>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
                <!--// End Page-Title -->

{{--                <div class="row m-t-20">--}}
{{--                    <div class="col-md-12">--}}
{{--                        <div class="card-box text-center shadow">--}}

                            <!--User details content start-->
{{--                            <div class="card">--}}
{{--                                <div class="card-header font-18">--}}
{{--                                   User Profile--}}
{{--                                </div>--}}
{{--                                <div class="card-body">--}}

{{--                                    <div class="d-flex justify-content-center"><img class="rounded wow pulse" src="{{asset($single_user->image ? 'uploads/'.$single_user->image : 'assets/common-assets/no_image.jpg')}}" height="100" width="150"  alt="Profile image"></div>--}}



{{--                                    <div class="row">--}}
{{--                                        <div class="col-md-8 offset-md-2 pt-3 pb-5">--}}
{{--                                            <div class="card">--}}
{{--                                                <ul class="list-group list-group-flush">--}}
{{--                                                    <li class="list-group-item d-flex justify-content-start">--}}
{{--                                                        <div class="w-50">Name :</div>--}}
{{--                                                        <div class="w-50">{{$single_user->name}}</div>--}}
{{--                                                    </li>--}}
{{--                                                    <li class="list-group-item d-flex justify-content-start">--}}
{{--                                                        <div class="w-50"> Role : </div>--}}
{{--                                                        <div class="w-50"> {{rtrim($data,',')}} </div>--}}
{{--                                                    </li>--}}
{{--                                                    <li class="list-group-item d-flex justify-content-start">--}}
{{--                                                        <div class="w-50">Employee ID :</div>--}}
{{--                                                        <div class="w-50"> {{$single_user->employee_id}}</div>--}}
{{--                                                    </li>--}}
{{--                                                    <li class="list-group-item d-flex justify-content-start">--}}
{{--                                                        <div class="w-50">Email :</div>--}}
{{--                                                        <div class="w-50">{{$single_user->email}}</div>--}}
{{--                                                    </li>--}}
{{--                                                    <li class="list-group-item d-flex justify-content-start">--}}
{{--                                                        <div class="w-50">Phone :</div>--}}
{{--                                                        <div class="w-50">{{$single_user->phone_no}}</div>--}}
{{--                                                    </li>--}}
{{--                                                    <li class="list-group-item d-flex justify-content-start">--}}
{{--                                                        <div class="w-50">Address :</div>--}}
{{--                                                        <div class="w-50">{{$single_user->address}}</div>--}}
{{--                                                    </li>--}}
{{--                                                    <li class="list-group-item d-flex justify-content-start">--}}
{{--                                                        <div class="w-50">Country :</div>--}}
{{--                                                        <div class="w-50"> {{$single_user->country}}</div>--}}
{{--                                                    </li>--}}
{{--                                                    <li class="list-group-item d-flex justify-content-start">--}}
{{--                                                        <div class="w-50"> State :</div>--}}
{{--                                                        <div class="w-50">{{$single_user->state}}</div>--}}
{{--                                                    </li>--}}
{{--                                                    <li class="list-group-item d-flex justify-content-start">--}}
{{--                                                        <div class="w-50">City :</div>--}}
{{--                                                        <div class="w-50"> {{$single_user->city}}</div>--}}
{{--                                                    </li>--}}
{{--                                                    <li class="list-group-item d-flex justify-content-start">--}}
{{--                                                        <div class="w-50">Post Code :</div>--}}
{{--                                                        <div class="w-50">{{$single_user->zip_code}}</div>--}}
{{--                                                    </li>--}}
{{--                                                </ul>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div> --}}
                                      <!--// End User details content start-->



{{--                        </div>  <!-- end card-box -->--}}
{{--                    </div> <!-- end col-md-12 -->--}}
{{--                </div> <!-- end row -->--}}
            </div> <!-- container -->

            <!--Tab table content start-->
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card-box">
                            <!-- Nav tabs -->
                            <ul class="nav nav-tabs profile-table-navtab m-4" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" data-toggle="tab" href="#pending_shelve_product">Pending Shelve Product</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#received_product">Received Product</a>
                                </li>
                                @if($shelfUse == 1)
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#shelved_product">Shelved Product</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#assigned_order">Assigned Order</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#picked_order">Picked Order</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#packed_order">Packed Order</a>
                                </li>
                                @endif
                            </ul>

                            <!-- Tab panels -->
                            <div class="container-fluid tab-content product-content">
                                <div id="pending_shelve_product" class="tab-pane active m-b-20"><br>
                                    <h5 class="text-center">Pending Shelved Product List</h5>

                                    <!--table pagination & search area-->
                                    <div class="product-inner p-b-10">
                                        <div class="table-list">  </div>
                                        <div class="row-wise-search table-terms">
                                            <input class="form-control mb-1" id="pending-shelved-product-row-wise-search" type="text" placeholder="Search....">
                                        </div>
                                    </div>
                                    <!--End table pagination & search area-->

                                    <div class="table-responsive">
{{--                                        <table id="pending_shelve_product_tab" class="table table-bordered">--}}
                                        <table id="pending_shelved_product_short_list" class="table table-bordered">
                                            <thead>
                                            <tr>
                                                <th class="header-cell" onclick="pending_shelved_product(0)">Invoice No.</th>
                                                <th class="header-cell" onclick="pending_shelved_product(0)">SKU</th>
                                                <th class="header-cell" onclick="pending_shelved_product(0)">Total Qty</th>
                                                @if($shelfUse == 1)
                                                    <th class="header-cell" onclick="pending_shelved_product(0)">Shelved Qty</th>
                                                @endif
                                                <th class="header-cell" onclick="pending_shelved_product(0)">Price</th>
                                                <th class="header-cell" onclick="pending_shelved_product(0)">Total Price</th>
                                                @if($shelfUse == 1)
                                                    <th class="header-cell" onclick="pending_shelved_product(0)">Shelve Status</th>
                                                @endif
                                                <th class="header-cell" onclick="pending_shelved_product(0)">Regular Price</th>
                                                <th class="header-cell" onclick="pending_shelved_product(0)">Sale Price</th>
                                            </tr>
                                            </thead>
                                            <tbody id="pending-shelved-product-tbody">
                                            @foreach ($user_pending_shelved_product as $pending_shelved_product)
                                                <tr>
                                                    <td>{{$pending_shelved_product->user_shelved_invoice_no->invoice_number ?? ''}}</td>
                                                    <td>{{$pending_shelved_product->user_shelved_product->sku ?? ''}}</td>
                                                    <td>{{$pending_shelved_product->quantity ?? ''}}</td>
                                                    @if($shelfUse == 1)
                                                        <td>{{$pending_shelved_product->shelved_quantity ?? ''}}</td>
                                                    @endif
                                                    <td>{{$pending_shelved_product->price ?? ''}}</td>
                                                    <td>{{$pending_shelved_product->total_price ?? ''}}</td>
                                                    @if($shelfUse == 1)
                                                        <td>{{$pending_shelved_product->shelving_status ?? ''}}</td>
                                                    @endif
                                                    <td>{{$pending_shelved_product->user_shelved_product->regular_price ?? ''}}</td>
                                                    <td>{{$pending_shelved_product->user_shelved_product->sale_price ?? ''}}</td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                @if($shelfUse == 1)
                                <div id="shelved_product" class="tab-pane fade m-b-20"><br>
                                    <h5 class="text-center">Shelved Product List</h5>

                                    <!--table pagination & search area-->
                                    <div class="product-inner p-b-10">
                                        <div class="table-list">  </div>
                                        <div class="row-wise-search table-terms">
                                            <input class="form-control mb-1" id="shelved_product_list" type="text" placeholder="Search....">
                                        </div>
                                    </div>
                                    <!--End table pagination & search area-->

                                    <div class="table-responsive">
{{--                                        <table id="shelved_product_tab" class="table table-bordered">--}}
                                        <table id="shelved_product_table_sort_list" class="table table-bordered">
                                            <thead>
                                            <tr>
                                                <th class="header-cell" onclick="shelved_product(0)">Invoice No.</th>
                                                <th class="header-cell" onclick="shelved_product(0)">SKU</th>
                                                <th class="header-cell" onclick="shelved_product(0)">Total Qty</th>
                                                <th class="header-cell" onclick="shelved_product(0)">Shelved Qty</th>
                                                <th class="header-cell" onclick="shelved_product(0)">Price</th>
                                                <th class="header-cell" onclick="shelved_product(0)">Total Price</th>
                                                <th class="header-cell" onclick="shelved_product(0)">Shelve Status</th>
                                                <th class="header-cell" onclick="shelved_product(0)">Regular Price</th>
                                                <th class="header-cell" onclick="shelved_product(0)">Sale Price</th>
                                            </tr>
                                            </thead>
                                            <tbody id="shelved_product_tbody">
                                            @foreach ($user_shelved_product as $shelved_product)
                                                <tr>
                                                    <td>{{$shelved_product->user_shelved_invoice_no->invoice_number}}</td>
                                                    <td>@if(isset($shelved_product->user_shelved_product->sku)) {{$shelved_product->user_shelved_product->sku }} @endif</td>
                                                    <td>{{$shelved_product->quantity}}</td>
                                                    <td>{{$shelved_product->shelved_quantity}}</td>
                                                    <td>{{$shelved_product->price}}</td>
                                                    <td>{{$shelved_product->total_price}}</td>
                                                    <td>{{$shelved_product->shelving_status}}</td>
                                                    <td>@if(isset($shelved_product->user_shelved_product->regular_price)) {{$shelved_product->user_shelved_product->regular_price }} @endif</td>
                                                    <td>@if(isset($shelved_product->user_shelved_product->sale_price)) {{$shelved_product->user_shelved_product->sale_price }} @endif</td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                @endif
                                <div id="received_product" class="tab-pane fade m-b-20"><br>
                                    <h5 class="text-center">Received Product</h5>

                                    <!--table pagination & search area-->
                                    <div class="product-inner p-b-10">
                                        <div class="table-list">  </div>
                                        <div class="row-wise-search table-terms">
                                            <input class="form-control mb-1" id="received-product-list" type="text" placeholder="Search....">
                                        </div>
                                    </div>
                                    <!--End table pagination & search area-->

                                    <div class="table-responsive">
{{--                                        <table id="received_product_tab" class="table table-striped table-bordered table-md" cellspacing="0" width="100%" >--}}
                                        <table id="received_product_sort_list" class="table table-striped table-bordered table-md" cellspacing="0" width="100%" >
                                            <thead>
                                            <tr>
                                                <th class="header-cell th-sm" onclick="received_product_list(0)">Invoice No.</th>
                                                <th class="header-cell th-sm" onclick="received_product_list(0)">Vendor</th>
                                                <th class="header-cell th-sm" onclick="received_product_list(0)">Received Date</th>
                                                <th class="header-cell th-sm" onclick="received_product_list(0)">Invoice Type</th>
                                                <th class="header-cell th-sm" onclick="received_product_list(0)">Action</th>
                                            </tr>
                                            </thead>
                                            <tbody id="received-product-tbody">
                                            @foreach($user_receive_product as $receive_product)
                                                <tr>
                                                    <td>{{$receive_product->invoice_number}}</td>
                                                    <td>{{$receive_product->vendor_info->name ?? ''}}</td>
                                                    <td>{{$receive_product->receive_date}}</td>
                                                    <td>
                                                        @if(isset($receive_product->return_order_id))
                                                            <a href="">Return Product invoice</a>
                                                        @else
                                                            New Product invoice
                                                        @endif
                                                    </td>
                                                    {{--                                                <td>{{count($receive_product->product_variations)}}</td>--}}
                                                    <td class="actions form_action">&nbsp;
                                                        <button type="button" class="vendor_btn_view btn-success" data-toggle="modal" data-target="#myModal{{$receive_product->id}}">View Product</button>
                                                    </td>



                                                    <!-- The Modal -->
                                                    <div class="modal fade" id="myModal{{$receive_product->id}}">
                                                        <div class="modal-dialog modal-lg">
                                                            <div class="modal-content">

                                                                <!-- Modal Header -->
                                                                <div class="modal-header">
                                                                    <h4 class="modal-title">Received Product Details</h4>
                                                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                                </div>

                                                                <!-- Modal body -->
                                                                <div class="modal-body">
                                                                    <div class="m-t-5 m-b-5 m-l-5 m-r-5">
                                                                        <div class="card b-r-2">
                                                                            <div class="row m-t-10">
                                                                                <div class="col-2 text-center">
                                                                                    <h6>SKU</h6>
                                                                                    <hr width="60%">
                                                                                </div>
                                                                                <div class="col-2 text-center">
                                                                                    <h6> Quantity </h6>
                                                                                    <hr width="60%">
                                                                                </div>
                                                                                <div class="col-2 text-center">
                                                                                    <h6> Price </h6>
                                                                                    <hr width="60%">
                                                                                </div>
                                                                                <div class="col-2 text-center">
                                                                                    <h6> Product Type </h6>
                                                                                    <hr width="60%">
                                                                                </div>
                                                                                @if($shelfUse == 1)
                                                                                    <div class="col-2 text-center">
                                                                                        <h6> Shelver </h6>
                                                                                        <hr width="60%">
                                                                                    </div>
                                                                                @endif
                                                                                <div class="col-2 text-center">
                                                                                    <h6> Total </h6>
                                                                                    <hr width="60%">
                                                                                </div>
                                                                            </div>
                                                                            @php
                                                                                $total_price = 0;
                                                                            @endphp
                                                                            @foreach($receive_product->invoice_product_variation_info as $product)
                                                                                <div class="row">
                                                                                    <div class="col-2 text-center">
                                                                                        <h7> {{$product->sku}} </h7>
                                                                                    </div>
                                                                                    <div class="col-2 text-center">
                                                                                        <h7> {{$product->pivot->quantity}} </h7>
                                                                                    </div>
                                                                                    <div class="col-2 text-center">
                                                                                        <h7> {{$product->pivot->price}} </h7>
                                                                                    </div>
                                                                                    <div class="col-2 text-center">
                                                                                        <h7> {{$product->pivot->product_type ? "non defected" : "defected"}} </h7>
                                                                                    </div>
                                                                                    @if($shelfUse == 1)
                                                                                        <div class="col-2 text-center">
                                                                                            <h7> @if(isset(\App\User::find($product->pivot->shelver_user_id)->name))
                                                                                                    {{\App\User::find($product->pivot->shelver_user_id)->name }}
                                                                                                @endif </h7>
                                                                                        </div>
                                                                                    @endif
                                                                                    <div class="col-2 text-center">
                                                                                        <h7> {{$product->pivot->total_price}} </h7>
                                                                                    </div>
                                                                                    @php
                                                                                        $total_price += $product->pivot->total_price;
                                                                                    @endphp

                                                                                </div>
                                                                            @endforeach
                                                                            <div class="row m-b-20 m-t-10">
                                                                                <div class="col-8 text-center">
                                                                                </div>
                                                                                <div class="col-2 text-center">
                                                                                    <h7 class="font-weight-bold"> Total Price</h7>
                                                                                </div>
                                                                                <div class="col-2 text-center">
                                                                                    <h7 class="font-weight-bold"> {{$total_price}}</h7>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div> <!-- end card -->
                                                                </div>

                                                                <!-- Modal footer -->
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>  <!-- // The Modal -->
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div id="assigned_order" class="tab-pane fade m-b-20"><br>
                                    <h5 class="text-center">Assigned Order List</h5>

                                    <!--table pagination & search area-->
                                    <div class="product-inner p-b-10">
                                        <div class="table-list">  </div>
                                        <div class="row-wise-search table-terms">
                                            <input class="form-control mb-1" id="assigned-order-list" type="text" placeholder="Search....">
                                        </div>
                                    </div>
                                    <!--End table pagination & search area-->

                                    <div class="table-responsive">
{{--                                        <table id="assigned_order_tab" class="table table-striped table-bordered table-md" cellspacing="0" width="100%" >--}}
                                        <table id="assigned_order_sort_list" class="table table-striped table-bordered table-md" cellspacing="0" width="100%" >
                                            <thead>
                                            <tr>
                                                <th class="header-cell th-sm" onclick="assigned_order_list(0)">Order No.</th>
                                                <th class="header-cell th-sm" onclick="assigned_order_list(0)">Status</th>
                                                <th class="header-cell th-sm" onclick="assigned_order_list(0)">Created Via</th>
                                                <th class="header-cell th-sm" onclick="assigned_order_list(0)">Name</th>
                                                <th class="header-cell th-sm" onclick="assigned_order_list(0)">Country</th>
                                                <th class="header-cell th-sm" onclick="assigned_order_list(0)">City</th>
                                                <th class="header-cell th-sm" onclick="assigned_order_list(0)">Order Product</th>
                                                <th class="header-cell th-sm" onclick="assigned_order_list(0)">Assigner</th>
                                                <th class="header-cell th-sm" onclick="assigned_order_list(0)">Total Price</th>
                                                <th class="header-cell th-sm" onclick="assigned_order_list(0)">Action</th>
                                            </tr>
                                            </thead>
                                            <tbody id="assigned-order-list-tbody">
                                            @foreach($user_assigned_order as $assigned_order)
                                                <tr>
                                                    <td>{{$assigned_order->order_number}}</td>
                                                    @if($assigned_order->status == 'processing')
                                                        <td><span class="label label-table label-warning">{{$assigned_order->status}}</span></td>
                                                    @elseif($assigned_order->status == 'completed')
                                                        <td><span class="label label-table label-success">{{$assigned_order->status}}</span></td>
                                                    @else
                                                        <td>{{$assigned_order->status}}</td>
                                                    @endif
                                                    @if($assigned_order->created_via == 'ebay')
                                                        <td><img src="{{asset('assets/common-assets/ebay-42x16.png')}}" alt="image"></td>
                                                    @else
                                                        <td>{{$assigned_order->created_via}}</td>
                                                    @endif
                                                    <td>{{$assigned_order->customer_name}}</td>
                                                    <td>{{$assigned_order->customer_country}}</td>
                                                    <td>{{$assigned_order->customer_city}}</td>
                                                    <td>{{count($assigned_order->product_variations)}}</td>
                                                    <td>{{$assigned_order->assigner_info->name ?? ''}}</td>
                                                    <td>{{$assigned_order->total_price}}</td>
                                                    <td class="actions form_action">&nbsp;
                                                        <button type="button"  class="vendor_btn_view btn-success" data-toggle="modal" data-target="#myModal{{$assigned_order->order_number}}">View Product</button>
                                                    </td>

                                                    <!-- The Modal -->
                                                    <div class="modal fade" id="myModal{{$assigned_order->order_number}}">
                                                        <div class="modal-dialog modal-lg">
                                                            <div class="modal-content">

                                                                <!-- Modal Header -->
                                                                <div class="modal-header">
                                                                    <h4 class="modal-title">Assign Order Details</h4>
                                                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                                </div>

                                                                <!-- Modal body -->
                                                                <div class="modal-body">
                                                                    <div class="m-t-5 m-b-5">
                                                                        <div style="border: 1px solid #ccc;">
                                                                            <div class="row assign-order-details m-t-10">
                                                                                <div class="col-3 text-center">
                                                                                    <h6> Name </h6>
                                                                                    <hr width="60%">
                                                                                </div>
                                                                                <div class="col-3 text-center">
                                                                                    <h6>SKU</h6>
                                                                                    <hr width="60%">
                                                                                </div>
                                                                                <div class="col-3 text-center">
                                                                                    <h6> Quantity </h6>
                                                                                    <hr width="60%">
                                                                                </div>
                                                                                <div class="col-3 text-center">
                                                                                    <h6> Price </h6>
                                                                                    <hr width="60%">
                                                                                </div>
                                                                            </div>
                                                                            @foreach($assigned_order->product_variations as $product)
                                                                                <div class="row">
                                                                                    <div class="col-3 text-center">
                                                                                        <h7> {{$product->pivot->name ?? ''}} </h7>
                                                                                    </div>
                                                                                    <div class="col-3 text-center">
                                                                                        <h7> {{$product->sku}} </h7>
                                                                                    </div>
                                                                                    <div class="col-3 text-center">
                                                                                        <h7> {{$product->pivot->quantity}} </h7>
                                                                                    </div>
                                                                                    <div class="col-3 text-center">
                                                                                        <h7> {{$product->pivot->price}} </h7>
                                                                                    </div>
                                                                                </div>
                                                                            @endforeach
                                                                            <div class="row m-b-20 m-t-10">
                                                                                <div class="col-6 text-center">
                                                                                </div>
                                                                                <div class="col-3 text-center">
                                                                                    <h7 class="font-weight-bold"> Total Price</h7>
                                                                                </div>
                                                                                <div class="col-3 text-center">
                                                                                    <h7 class="font-weight-bold"> {{$assigned_order->total_price}}</h7>
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                          <!--- Shipping Billing --->
                                                                        <div style="border: 1px solid #ccc" class="m-t-20">
                                                                            <div class="shipping-billing">
                                                                                <div class="shipping">
                                                                                    <div class="d-block mb-5">
                                                                                        <h6>Shipping</h6>
                                                                                        <hr class="m-t-5 float-left" width="50%">
                                                                                    </div>
                                                                                    <div class="shipping-content">
                                                                                        {!! $assigned_order->shipping !!}
                                                                                    </div>
                                                                                </div>
                                                                                <div class="billing">
                                                                                    <div class="d-block mb-5">
                                                                                        <h6> Billing </h6>
                                                                                        <hr class="m-t-5 float-left" width="50%">
                                                                                    </div>
                                                                                    <div class="billing-content">
                                                                                        <div class="d-flex justify-content-start mb-1">
                                                                                            <div class="content-left">
                                                                                                <h7> Name </h7>
                                                                                            </div>
                                                                                            <div class="content-right">
                                                                                                <h7> : {{$assigned_order->customer_name}} </h7>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="d-flex justify-content-start mb-1">
                                                                                            <div class="content-left">
                                                                                                <h7> Email </h7>
                                                                                            </div>
                                                                                            <div class="content-right">
                                                                                                <h7> : {{$assigned_order->customer_email}} </h7>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="d-flex justify-content-start mb-1">
                                                                                            <div class="content-left">
                                                                                                <h7> Phone </h7>
                                                                                            </div>
                                                                                            <div class="content-right">
                                                                                                <h7> : {{$assigned_order->customer_phone}} </h7>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="d-flex justify-content-start mb-1">
                                                                                            <div class="content-left">
                                                                                                <h7> City </h7>
                                                                                            </div>
                                                                                            <div class="content-right">
                                                                                                <h7> : {{$assigned_order->customer_city}} </h7>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="d-flex justify-content-start mb-1">
                                                                                            <div class="content-left">
                                                                                                <h7> State </h7>
                                                                                            </div>
                                                                                            <div class="content-right">
                                                                                                <h7> : {{$assigned_order->customer_state}} </h7>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="d-flex justify-content-start mb-1">
                                                                                            <div class="content-left">
                                                                                                <h7> Zip Code </h7>
                                                                                            </div>
                                                                                            <div class="content-right">
                                                                                                <h7> : {{$assigned_order->customer_zip_code}} </h7>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="d-flex justify-content-start mb-2">
                                                                                            <div class="content-left">
                                                                                                <h7> Country </h7>
                                                                                            </div>
                                                                                            <div class="content-right">
                                                                                                <h7> : {{$assigned_order->customer_country}} </h7>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div> <!--Billing and shipping -->

                                                                    </div> <!-- end card -->
                                                                </div>

                                                                <!-- Modal footer -->
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>  <!-- // The Modal -->
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div id="picked_order" class="tab-pane fade m-b-20"><br>
                                    <h5 class="text-center">Picked Order List</h5>

                                    <!--table pagination & search area-->
                                    <div class="product-inner p-b-10">
                                        <div class="table-list">  </div>
                                        <div class="row-wise-search table-terms">
                                            <input class="form-control mb-1" id="picked-order-list" type="text" placeholder="Search....">
                                        </div>
                                    </div>
                                    <!--End table pagination & search area-->

                                    <div class="table-responsive">
{{--                                        <table id="picked_order_tab" class="table table-striped table-bordered table-md" cellspacing="0" width="100%" >--}}
                                        <table id="picked_sort_order_list" class="table table-striped table-bordered table-md" cellspacing="0" width="100%" >
                                            <thead>
                                            <tr>
                                                <th class="header-cell th-sm" onclick="picked_order_list(0)">Order No.</th>
                                                <th class="header-cell th-sm" onclick="picked_order_list(0)">Status</th>
                                                <th class="header-cell th-sm" onclick="picked_order_list(0)">Created Via</th>
                                                <th class="header-cell th-sm" onclick="picked_order_list(0)">Name</th>
                                                <th class="header-cell th-sm" onclick="picked_order_list(0)">Country</th>
                                                <th class="header-cell th-sm" onclick="picked_order_list(0)">City</th>
                                                <th class="header-cell th-sm" onclick="picked_order_list(0)">Order Product</th>
                                                <th class="header-cell th-sm" onclick="picked_order_list(0)">Assigner</th>
                                                <th class="header-cell th-sm" onclick="picked_order_list(0)">Total Price</th>
                                                <th class="header-cell th-sm" onclick="picked_order_list(0)">Action</th>
                                            </tr>
                                            </thead>
                                            <tbody id="picked-order-list-tbody">
                                            @foreach($user_picked_order as $picked_order)
                                                <tr>
                                                    <td>{{$picked_order->order_number}}</td>
                                                    @if($picked_order->status == 'processing')
                                                        <td><span class="label label-table label-warning">{{$picked_order->status}}</span></td>
                                                    @elseif($picked_order->status == 'completed')
                                                        <td><span class="label label-table label-success">{{$picked_order->status}}</span></td>
                                                    @else
                                                        <td>{{$packed_order->status}}</td>
                                                    @endif
                                                    @if($picked_order->created_via == 'ebay')
                                                        <td><img src="{{asset('assets/common-assets/ebay-42x16.png')}}" alt="image"></td>
                                                    @else
                                                        <td>{{$picked_order->created_via}}</td>
                                                    @endif
                                                    <td>{{$picked_order->customer_name}}</td>
                                                    <td>{{$picked_order->customer_country}}</td>
                                                    <td>{{$picked_order->customer_city}}</td>
                                                    <td>{{count($picked_order->product_variations)}}</td>
                                                    <td>{{$picked_order->assigner_info->name ?? ''}}</td>
                                                    <td>{{$picked_order->total_price}}</td>
                                                    <td class="actions form_action">&nbsp;
                                                        <button type="button" class="vendor_btn_view btn-success" data-toggle="modal" data-target="#myModal{{$picked_order->order_number}}">View Product</button>
                                                    </td>


                                                    <!-- The Modal -->
                                                    <div class="modal fade" id="myModal{{$picked_order->order_number}}">
                                                        <div class="modal-dialog modal-lg">
                                                            <div class="modal-content">

                                                                <!-- Modal Header -->
                                                                <div class="modal-header">
                                                                    <h4 class="modal-title">Picked Product Details</h4>
                                                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                                </div>

                                                                <!-- Modal body -->
                                                                <div class="modal-body">
                                                                    <div class="m-t-5 m-b-5 m-l-5 m-r-5">
                                                                        <div style="border: 1px solid #ccc;">
                                                                            <div class="row m-t-10">
                                                                                <div class="col-3 text-center">
                                                                                    <h6> Name </h6>
                                                                                    <hr width="60%">
                                                                                </div>
                                                                                <div class="col-3 text-center">
                                                                                    <h6>SKU</h6>
                                                                                    <hr width="60%">
                                                                                </div>
                                                                                <div class="col-3 text-center">
                                                                                    <h6> Quantity </h6>
                                                                                    <hr width="60%">
                                                                                </div>
                                                                                <div class="col-3 text-center">
                                                                                    <h6> Price </h6>
                                                                                    <hr width="60%">
                                                                                </div>
                                                                            </div>
                                                                            @foreach($picked_order->product_variations as $product)
                                                                                <div class="row">
                                                                                    <div class="col-3 text-center">
                                                                                        <h7> {{$product->pivot->name ?? ''}} </h7>
                                                                                    </div>
                                                                                    <div class="col-3 text-center">
                                                                                        <h7> {{$product->sku}} </h7>
                                                                                    </div>
                                                                                    <div class="col-3 text-center">
                                                                                        <h7> {{$product->pivot->quantity}} </h7>
                                                                                    </div>
                                                                                    <div class="col-3 text-center">
                                                                                        <h7> {{$product->pivot->price}} </h7>
                                                                                    </div>
                                                                                </div>
                                                                            @endforeach
                                                                            <div class="row m-b-20 m-t-10">
                                                                                <div class="col-6">
                                                                                </div>
                                                                                <div class="col-3 text-center">
                                                                                    <h7 class="font-weight-bold"> Total Price</h7>
                                                                                </div>
                                                                                <div class="col-3 text-center">
                                                                                    <h7 class="font-weight-bold"> {{$picked_order->total_price}}</h7>
                                                                                </div>
                                                                            </div>
                                                                        </div>



                                                                        <!---Billing Shipping --->
                                                                        <div style="border: 1px solid #ccc" class="m-t-20">
                                                                            <div class="shipping-billing">
                                                                                <div class="shipping">
                                                                                    <div class="d-block mb-5">
                                                                                        <h6>Shipping</h6>
                                                                                        <hr class="m-t-5 float-left" width="50%">
                                                                                    </div>
                                                                                    <div class="shipping-content">
                                                                                        {!! $picked_order->shipping !!}
                                                                                    </div>
                                                                                </div>
                                                                                <div class="billing">
                                                                                    <div class="d-block mb-5">
                                                                                        <h6> Billing </h6>
                                                                                        <hr class="m-t-5 float-left" width="50%">
                                                                                    </div>
                                                                                    <div class="billing-content">
                                                                                        <div class="d-flex justify-content-start mb-1">
                                                                                            <div class="content-left">
                                                                                                <h7> Name </h7>
                                                                                            </div>
                                                                                            <div class="content-right">
                                                                                                <h7> : {{$picked_order->customer_name}} </h7>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="d-flex justify-content-start mb-1">
                                                                                            <div class="content-left">
                                                                                                <h7> Email </h7>
                                                                                            </div>
                                                                                            <div class="content-right">
                                                                                                <h7> : {{$picked_order->customer_email}} </h7>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="d-flex justify-content-start mb-1">
                                                                                            <div class="content-left">
                                                                                                <h7> Phone </h7>
                                                                                            </div>
                                                                                            <div class="content-right">
                                                                                                <h7> : {{$picked_order->customer_phone}} </h7>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="d-flex justify-content-start mb-1">
                                                                                            <div class="content-left">
                                                                                                <h7> City </h7>
                                                                                            </div>
                                                                                            <div class="content-right">
                                                                                                <h7> : {{$picked_order->customer_city}} </h7>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="d-flex justify-content-start mb-1">
                                                                                            <div class="content-left">
                                                                                                <h7> State </h7>
                                                                                            </div>
                                                                                            <div class="content-right">
                                                                                                <h7> : {{$picked_order->customer_state}} </h7>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="d-flex justify-content-start mb-1">
                                                                                            <div class="content-left">
                                                                                                <h7> Zip Code </h7>
                                                                                            </div>
                                                                                            <div class="content-right">
                                                                                                <h7> : {{$picked_order->customer_zip_code}} </h7>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="d-flex justify-content-start mb-2">
                                                                                            <div class="content-left">
                                                                                                <h7> Country </h7>
                                                                                            </div>
                                                                                            <div class="content-right">
                                                                                                <h7> : {{$picked_order->customer_country}} </h7>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div> <!--Billing and shipping -->

                                                                    </div> <!-- end card -->
                                                                </div>

                                                                <!-- Modal footer -->
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>  <!-- // The Modal -->
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div id="packed_order" class="tab-pane fade m-b-20"><br>
                                    <h5 class="text-center">Packed Order List</h5>

                                    <!--table pagination & search area-->
                                    <div class="product-inner p-b-10">
                                        <div class="table-list">  </div>
                                        <div class="row-wise-search table-terms">
                                            <input class="form-control mb-1" id="packed-order-list" type="text" placeholder="Search....">
                                        </div>
                                    </div>
                                    <!--End table pagination & search area-->

                                    <div class="table-responsive">
{{--                                        <table id="packed_order_tab" class="table table-striped table-bordered table-md" cellspacing="0" width="100%" >--}}
                                        <table id="packed_order_sort_list" class="table table-striped table-bordered table-md" cellspacing="0" width="100%" >
                                            <thead>
                                            <tr>
                                                <th class="header-cell th-sm" onclick="packed_order_list(0)">Order No.</th>
                                                <th class="header-cell th-sm" onclick="packed_order_list(0)">Status</th>
                                                <th class="header-cell th-sm" onclick="packed_order_list(0)">Created Via</th>
                                                <th class="header-cell th-sm" onclick="packed_order_list(0)">Name</th>
                                                <th class="header-cell th-sm" onclick="packed_order_list(0)">Country</th>
                                                <th class="header-cell th-sm" onclick="packed_order_list(0)">City</th>
                                                <th class="header-cell th-sm" onclick="packed_order_list(0)">Order Product</th>
                                                <th class="header-cell th-sm" onclick="packed_order_list(0)">Picker</th>
                                                <th class="header-cell th-sm" onclick="packed_order_list(0)">Assigner</th>
                                                <th class="header-cell th-sm" onclick="packed_order_list(0)">Total Price</th>
                                                <th class="header-cell th-sm" onclick="packed_order_list(0)">Action</th>
                                            </tr>
                                            </thead>
                                            <tbody id="packed-order-list-tbody">
                                            @foreach($user_packed_order as $packed_order)
                                                <tr>
                                                    <td>{{$packed_order->order_number}}</td>
                                                    @if($packed_order->status == 'processing')
                                                        <td><span class="label label-table label-warning">{{$packed_order->status}}</span></td>
                                                    @elseif($packed_order->status == 'completed')
                                                        <td><span class="label label-table label-success">{{$packed_order->status}}</span></td>
                                                    @else
                                                        <td>{{$packed_order->status}}</td>
                                                    @endif
                                                    @if($packed_order->created_via == 'ebay')
                                                        <td><img src="{{asset('assets/common-assets/ebay-42x16.png')}}" alt="image"></td>
                                                    @else
                                                        <td>{{$packed_order->created_via}}</td>
                                                    @endif
                                                    <td>{{$packed_order->customer_name}}</td>
                                                    <td>{{$packed_order->customer_country}}</td>
                                                    <td>{{$packed_order->customer_city}}</td>
                                                    <td>{{count($packed_order->product_variations)}}</td>
                                                    <td>{{$packed_order->picker_info->name ?? ''}}</td>
                                                    <td>{{$packed_order->assigner_info->name ?? ''}}</td>
                                                    <td>{{$packed_order->total_price}}</td>
                                                    <td class="actions form_action">&nbsp;
                                                        <button type="button" class="vendor_btn_view btn-success" data-toggle="modal" data-target="#myModal{{$packed_order->id}}{{$packed_order->order_number}}">View Product</button>
                                                    </td>


                                                    <!-- The Modal -->
                                                    <div class="modal fade" id="myModal{{$packed_order->id}}{{$packed_order->order_number}}">
                                                        <div class="modal-dialog modal-lg">
                                                            <div class="modal-content">

                                                                <!-- Modal Header -->
                                                                <div class="modal-header">
                                                                    <h4 class="modal-title">Packed Order Details</h4>
                                                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                                </div>

                                                                <!-- Modal body -->
                                                                <div class="modal-body">
                                                                    <div class="m-t-5 m-b-5 m-l-5 m-r-5">
                                                                        <div style="border: 1px solid #ccc;">
                                                                            <div class="row m-t-10">
                                                                                <div class="col-3 text-center">
                                                                                    <h6> Name </h6>
                                                                                    <hr width="60%">
                                                                                </div>
                                                                                <div class="col-3 text-center">
                                                                                    <h6>SKU</h6>
                                                                                    <hr width="60%">
                                                                                </div>
                                                                                <div class="col-3 text-center">
                                                                                    <h6> Quantity </h6>
                                                                                    <hr width="60%">
                                                                                </div>
                                                                                <div class="col-3 text-center">
                                                                                    <h6> Price </h6>
                                                                                    <hr width="60%">
                                                                                </div>
                                                                            </div>
                                                                            @foreach($packed_order->product_variations as $product)
                                                                                <div class="row">
                                                                                    <div class="col-3 text-center">
                                                                                        <h7> {{$product->pivot->name ?? ''}} </h7>
                                                                                    </div>
                                                                                    <div class="col-3 text-center">
                                                                                        <h7> {{$product->sku}} </h7>
                                                                                    </div>
                                                                                    <div class="col-3 text-center">
                                                                                        <h7> {{$product->pivot->quantity}} </h7>
                                                                                    </div>
                                                                                    <div class="col-3 text-center">
                                                                                        <h7> {{$product->pivot->price}} </h7>
                                                                                    </div>
                                                                                </div>
                                                                            @endforeach
                                                                            <div class="row m-b-20 m-t-10">
                                                                                <div class="col-6 text-center"></div>
                                                                                <div class="col-3 text-center">
                                                                                    <h7 class="font-weight-bold"> Total Price</h7>
                                                                                </div>
                                                                                <div class="col-3 text-center">
                                                                                    <h7 class="font-weight-bold"> {{$packed_order->total_price}}</h7>
                                                                                </div>
                                                                            </div>
                                                                        </div>



                                                                            <!---Billing Shipping --->
                                                                        <div style="border: 1px solid #ccc" class="m-t-20">
                                                                            <div class="shipping-billing">
                                                                                <div class="shipping">
                                                                                    <div class="d-block mb-5">
                                                                                        <h6>Shipping</h6>
                                                                                        <hr class="m-t-5 float-left" width="50%">
                                                                                    </div>
                                                                                    <div class="shipping-content">
                                                                                        {!! $packed_order->shipping !!}
                                                                                    </div>
                                                                                </div>
                                                                                <div class="billing">
                                                                                    <div class="d-block mb-5">
                                                                                        <h6> Billing </h6>
                                                                                        <hr class="m-t-5 float-left" width="50%">
                                                                                    </div>
                                                                                    <div class="billing-content">
                                                                                        <div class="d-flex justify-content-start mb-1">
                                                                                            <div class="content-left">
                                                                                                <h7> Name </h7>
                                                                                            </div>
                                                                                            <div class="content-right">
                                                                                                <h7> : {{$packed_order->customer_name}} </h7>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="d-flex justify-content-start mb-1">
                                                                                            <div class="content-left">
                                                                                                <h7> Email </h7>
                                                                                            </div>
                                                                                            <div class="content-right">
                                                                                                <h7> : {{$packed_order->customer_email}} </h7>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="d-flex justify-content-start mb-1">
                                                                                            <div class="content-left">
                                                                                                <h7> Phone </h7>
                                                                                            </div>
                                                                                            <div class="content-right">
                                                                                                <h7> : {{$packed_order->customer_phone}} </h7>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="d-flex justify-content-start mb-1">
                                                                                            <div class="content-left">
                                                                                                <h7> City </h7>
                                                                                            </div>
                                                                                            <div class="content-right">
                                                                                                <h7> : {{$packed_order->customer_city}} </h7>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="d-flex justify-content-start mb-1">
                                                                                            <div class="content-left">
                                                                                                <h7> State </h7>
                                                                                            </div>
                                                                                            <div class="content-right">
                                                                                                <h7> : {{$packed_order->customer_state}} </h7>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="d-flex justify-content-start mb-1">
                                                                                            <div class="content-left">
                                                                                                <h7> Zip Code </h7>
                                                                                            </div>
                                                                                            <div class="content-right">
                                                                                                <h7> : {{$packed_order->customer_zip_code}} </h7>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="d-flex justify-content-start mb-2">
                                                                                            <div class="content-left">
                                                                                                <h7> Country </h7>
                                                                                            </div>
                                                                                            <div class="content-right">
                                                                                                <h7> : {{$packed_order->customer_country}} </h7>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div> <!--Billing and shipping -->

                                                                    </div> <!-- end card -->
                                                                </div>

                                                                <!-- Modal footer -->
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>  <!-- // The Modal -->
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--// End Tab table content start-->


        </div> <!-- content -->
    </div>  <!-- content page -->



{{--    <script>--}}
{{--        $(document).ready(function () {--}}
{{--            $('#assigned_order_tab').DataTable();--}}
{{--            $('.dataTables_length').addClass('bs-select');--}}

{{--            $('#picked_order_tab').DataTable();--}}
{{--            $('.dataTables_length').addClass('bs-select');--}}

{{--            $('#packed_order_tab').DataTable();--}}
{{--            $('.dataTables_length').addClass('bs-select');--}}



{{--            $('#received_product_tab').DataTable();--}}
{{--            $('.dataTables_length').addClass('bs-select');--}}

{{--            // Default Datatable--}}
{{--            $('#shelved_product_tab').DataTable();--}}
{{--            $('.dataTables_length').addClass('bs-select');--}}

{{--            $('#pending_shelve_product_tab').DataTable();--}}
{{--            $('.dataTables_length').addClass('bs-select');--}}

{{--        } );--}}

{{--    </script>--}}


    <script>

        //Datatable row-wise searchable option 1st Tab
        $(document).ready(function(){
            $("#pending-shelved-product-row-wise-search").on("keyup", function() {
                let value = $(this).val().toLowerCase();
                $("#pending-shelved-product-tbody tr").filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
            });
        });
        //Datatable row-wise searchable option 2nd Tab
        $(document).ready(function(){
            $("#shelved_product_list").on("keyup", function() {
                let value = $(this).val().toLowerCase();
                $("#shelved_product_tbody tr").filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
            });
        });

        //Datatable row-wise searchable option 3rd Tab
        $(document).ready(function(){
            $("#received-product-list").on("keyup", function() {
                let value = $(this).val().toLowerCase();
                $("#received-product-tbody tr").filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
            });
        });

        //Datatable row-wise searchable option 4th Tab
        $(document).ready(function(){
            $("#assigned-order-list").on("keyup", function() {
                let value = $(this).val().toLowerCase();
                $("#assigned-order-list-tbody tr").filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
            });
        });

        //Datatable row-wise searchable option 5th Tab
        $(document).ready(function(){
            $("#picked-order-list").on("keyup", function() {
                let value = $(this).val().toLowerCase();
                $("#picked-order-list-tbody tr").filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
            });
        });

        //Datatable row-wise searchable option 6th Tab
        $(document).ready(function(){
            $("#packed-order-list").on("keyup", function() {
                let value = $(this).val().toLowerCase();
                $("#packed-order-list-tbody tr").filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
            });
        });




        //sort ascending and descending table rows js 1st Tab
        function pending_shelved_product(n) {
            let table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
            table = document.getElementById("pending_shelved_product_short_list");
            switching = true;
            dir = "asc";
            while (switching) {
                switching = false;
                rows = table.getElementsByTagName("TR");
                for (i = 1; i < rows.length - 1; i++) {
                    shouldSwitch = false;
                    x = rows[i].getElementsByTagName("TD")[n];
                    y = rows[i + 1].getElementsByTagName("TD")[n];
                    if (dir == "asc") {
                        if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
                            shouldSwitch = true;
                            break;
                        }
                    } else if (dir == "desc") {
                        if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
                            shouldSwitch = true;
                            break;
                        }
                    }
                }
                if (shouldSwitch) {
                    rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
                    switching = true;
                    switchcount++;
                } else {
                    if (switchcount == 0 && dir == "asc") {
                        dir = "desc";
                        switching = true;
                    }
                }
            }
        }


        //sort ascending and descending table rows js 2nd Tab
        function shelved_product(n) {
            let table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
            table = document.getElementById("shelved_product_table_sort_list");
            switching = true;
            dir = "asc";
            while (switching) {
                switching = false;
                rows = table.getElementsByTagName("TR");
                for (i = 1; i < rows.length - 1; i++) {
                    shouldSwitch = false;
                    x = rows[i].getElementsByTagName("TD")[n];
                    y = rows[i + 1].getElementsByTagName("TD")[n];
                    if (dir == "asc") {
                        if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
                            shouldSwitch = true;
                            break;
                        }
                    } else if (dir == "desc") {
                        if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
                            shouldSwitch = true;
                            break;
                        }
                    }
                }
                if (shouldSwitch) {
                    rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
                    switching = true;
                    switchcount++;
                } else {
                    if (switchcount == 0 && dir == "asc") {
                        dir = "desc";
                        switching = true;
                    }
                }
            }
        }


        //sort ascending and descending table rows js 3rd Tab
        function received_product_list(n) {
            let table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
            table = document.getElementById("received_product_sort_list");
            switching = true;
            dir = "asc";
            while (switching) {
                switching = false;
                rows = table.getElementsByTagName("TR");
                for (i = 1; i < rows.length - 1; i++) {
                    shouldSwitch = false;
                    x = rows[i].getElementsByTagName("TD")[n];
                    y = rows[i + 1].getElementsByTagName("TD")[n];
                    if (dir == "asc") {
                        if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
                            shouldSwitch = true;
                            break;
                        }
                    } else if (dir == "desc") {
                        if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
                            shouldSwitch = true;
                            break;
                        }
                    }
                }
                if (shouldSwitch) {
                    rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
                    switching = true;
                    switchcount++;
                } else {
                    if (switchcount == 0 && dir == "asc") {
                        dir = "desc";
                        switching = true;
                    }
                }
            }
        }

        //sort ascending and descending table rows js 4th Tab
        function assigned_order_list(n) {
            let table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
            table = document.getElementById("assigned_order_sort_list");
            switching = true;
            dir = "asc";
            while (switching) {
                switching = false;
                rows = table.getElementsByTagName("TR");
                for (i = 1; i < rows.length - 1; i++) {
                    shouldSwitch = false;
                    x = rows[i].getElementsByTagName("TD")[n];
                    y = rows[i + 1].getElementsByTagName("TD")[n];
                    if (dir == "asc") {
                        if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
                            shouldSwitch = true;
                            break;
                        }
                    } else if (dir == "desc") {
                        if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
                            shouldSwitch = true;
                            break;
                        }
                    }
                }
                if (shouldSwitch) {
                    rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
                    switching = true;
                    switchcount++;
                } else {
                    if (switchcount == 0 && dir == "asc") {
                        dir = "desc";
                        switching = true;
                    }
                }
            }
        }


        //sort ascending and descending table rows js 5th Tab
        function picked_order_list(n) {
            let table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
            table = document.getElementById("picked_sort_order_list");
            switching = true;
            dir = "asc";
            while (switching) {
                switching = false;
                rows = table.getElementsByTagName("TR");
                for (i = 1; i < rows.length - 1; i++) {
                    shouldSwitch = false;
                    x = rows[i].getElementsByTagName("TD")[n];
                    y = rows[i + 1].getElementsByTagName("TD")[n];
                    if (dir == "asc") {
                        if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
                            shouldSwitch = true;
                            break;
                        }
                    } else if (dir == "desc") {
                        if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
                            shouldSwitch = true;
                            break;
                        }
                    }
                }
                if (shouldSwitch) {
                    rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
                    switching = true;
                    switchcount++;
                } else {
                    if (switchcount == 0 && dir == "asc") {
                        dir = "desc";
                        switching = true;
                    }
                }
            }
        }


        //sort ascending and descending table rows js 6th Tab
        function packed_order_list(n) {
            let table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
            table = document.getElementById("packed_order_sort_list");
            switching = true;
            dir = "asc";
            while (switching) {
                switching = false;
                rows = table.getElementsByTagName("TR");
                for (i = 1; i < rows.length - 1; i++) {
                    shouldSwitch = false;
                    x = rows[i].getElementsByTagName("TD")[n];
                    y = rows[i + 1].getElementsByTagName("TD")[n];
                    if (dir == "asc") {
                        if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
                            shouldSwitch = true;
                            break;
                        }
                    } else if (dir == "desc") {
                        if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
                            shouldSwitch = true;
                            break;
                        }
                    }
                }
                if (shouldSwitch) {
                    rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
                    switching = true;
                    switchcount++;
                } else {
                    if (switchcount == 0 && dir == "asc") {
                        dir = "desc";
                        switching = true;
                    }
                }
            }
        }


        // sort ascending descending icon active and active-remove js
        $('.header-cell').click(function() {
            let isSortedAsc  = $(this).hasClass('sort-asc');
            let isSortedDesc = $(this).hasClass('sort-desc');
            let isUnsorted = !isSortedAsc && !isSortedDesc;

            $('.header-cell').removeClass('sort-asc sort-desc');

            if (isUnsorted || isSortedDesc) {
                $(this).addClass('sort-asc');
            } else if (isSortedAsc) {
                $(this).addClass('sort-desc');
            }
        });

        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    $('#blah').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        $("#imgInp").change(function() {
            $('#user_edit_image').hide();
            $('#blah').show();
            readURL(this);
        });

    </script>


@endsection
