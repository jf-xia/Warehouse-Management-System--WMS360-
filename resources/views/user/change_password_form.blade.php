
@extends('master')

@section('title')
    User List | Change Password | WMS360
@endsection

@section('content')
    <div class="content-page">
        <!-- Start content -->
        <div class="content">
            <div class="container-fluid">


                <div class="d-flex justify-content-center align-items-center">
                    <div>
                        <ol class="breadcrumb page-breadcrumb">
                            <li class="breadcrumb-item">User List</li>
                            <li class="breadcrumb-item active" aria-current="page">Change Password</li>
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
                            @if (Session::has('password_success_msg'))
                                <div class="alert alert-success">
                                    {!! Session::get('password_success_msg') !!}
                                </div>
                            @endif

                                @if (Session::has('password_not_match_msg'))
                                    <div class="alert alert-danger">
                                        {!! Session::get('password_not_match_msg') !!}
                                    </div>
                                @endif

                            <form role="form" class="vendor-form mobile-responsive" action="{{url('user/update-password')}}" method="post">
                                @csrf
                                <div class="form-group row">
                                    <div class="col-md-1"></div>
                                    <label for="name" class="col-md-2 col-form-label">Old Password</label>
                                    <div class="col-md-8">
                                        <input type="password" name="old_password" class="form-control" id="old_password" value="" placeholder="Enter  old password" required>
                                    </div>
                                    <div class="col-md-1"></div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-md-1"></div>
                                    <label for="name" class="col-md-2 col-form-label">New Password</label>
                                    <div class="col-md-8">
                                        <input type="password" name="password" class="form-control" id="password" value="" placeholder="Enter  new password" required>
                                    </div>
                                    <div class="col-md-1"></div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-md-1"></div>
                                    <label for="name" class="col-md-2 col-form-label">Confirm New Password</label>
                                    <div class="col-md-8">
                                        <input type="password" name="password_confirmation" class="form-control" id="password_confirmation" value="" placeholder="Enter confirm password" req
                                        >
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
                        </div>  <!-- card-box -->
                    </div> <!-- end col -->
                </div>
                <!-- end row -->
            </div> <!-- container -->
        </div> <!-- content -->

    </div>
@endsection
