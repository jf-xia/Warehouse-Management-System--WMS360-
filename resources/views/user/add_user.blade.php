@extends('master')
@section('content')

    <div class="content-page">
        <!-- Start content -->
        <div class="content">
            <div class="container-fluid">

                <!-- Page-Title -->
                <div class="row">
                    <div class="col-md-12 text-center">
                        <div class="vendor-title">
                            <p>Add User</p>
                        </div>
                    </div>
                </div>

                <div class="row m-t-20">
                    <div class="col-md-12">
                        <div class="card-box shadow">

                            @if($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach($errors->all() as $error)
                                        <li>{{$error}}</li>
                                    @endforeach
                                </ul>
                            </div>
                            @endif

                            @if(Session::has('user_add_success_msg'))
                                <div class="alert alert-success">
                                    {!! Session::get('user_add_success_msg') !!}
                                </div>
                            @endif

                            <form role="form" class="vendor-form mobile-responsive" action="{{url('save-user')}}" method="post" enctype="multipart/form-data" data-parsley-validate>
                                @csrf

                                <div class="form-group row">
                                    <div class="col-md-1"></div>
                                    <label for="first_name" class="col-md-2 col-form-label required">First Name</label>
                                    <div class="col-md-8 wow pulse">
                                        <input type="text" name="name" data-parsley-maxlength="30" value="{{old('name')}}" class="form-control"
                                               id="name" placeholder="First Name" required>
                                    </div>
                                    <div class="col-md-1"></div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-md-1"></div>
                                    <label for="last_name" class="col-md-2 col-form-label required">Last Name</label>
                                    <div class="col-md-8 wow pulse">
                                        <input type="text" name="last_name" data-parsley-maxlength="30" value="{{old('last_name')}}" class="form-control"
                                               id="last_name" placeholder="Last Name" required>
                                    </div>
                                    <div class="col-md-1"></div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-md-1"></div>
                                    <label for="employee_id" class="col-md-2 col-form-label ">Employee Id</label>
                                    <div class="col-md-8 wow pulse">
                                        <input type="text" name="employee_id" data-parsley-maxlength="30" value="{{old('employee_id')}}" class="form-control"
                                               id="employee_id" placeholder="Employee ID">
                                    </div>
                                    <div class="col-md-1"></div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-md-1"></div>
                                    <label for="email" class="col-md-2 col-form-label required">Email Address</label>
                                    <div class="col-md-8 wow pulse">
                                        <input type="email" name="email" parsley-type="email" value="{{old('email')}}" class="form-control"
                                               id="email" placeholder="Email" required>
                                    </div>
                                    <div class="col-md-1"></div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-md-1"></div>
                                    <label for="password" class="col-md-2 col-form-label required">Password</label>
                                    <div class="col-md-8 wow pulse">
                                        <input type="password"
                                               data-parsley-minlength="8" name="password" class="form-control"
                                               id="password" placeholder="Password" data-parsley-required />
                                    </div>
                                    <div class="col-md-1"></div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-md-1"></div>
                                    <label for="password_confirmation" class="col-md-2 col-form-label required">Confirm Password</label>
                                    <div class="col-md-8 wow pulse">
                                        <input type="password" data-parsley-minlength="8" name="password_confirmation"  class="form-control"
                                               id="password_confirmation" placeholder="Password confirmation" data-parsley-required />
                                    </div>
                                    <div class="col-md-1"></div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-md-1"></div>
                                    <label for="role" class="col-md-2 col-form-label required">Role</label>
                                    <div class="col-md-8 wow pulse d-flex align-items-center">
{{--                                        <select class="form-control" name="role" id="role" >--}}
{{--                                            <option value="">Select role</option>--}}
{{--                                            @foreach($all_role as $role)--}}
{{--                                                <option value="{{$role->id}}">{{$role->role_name}}</option>--}}
{{--                                            @endforeach--}}
{{--                                        </select>--}}
                                        @foreach($all_role as $role)
                                            <input type="checkbox" name="role[]" value="{{$role->id}}" data-parsley-multiple="mymultiplelink" required>{{$role->role_name}}
                                        @endforeach
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-md-1"></div>
                                    <label for="phone_no" class="col-md-2 col-form-label required">Phone No</label>
                                    <div class="col-md-8 wow pulse">
                                        <input type="number" name="phone_no" data-parsley-maxlength="30" value="{{old('phone_no')}}" class="form-control"
                                               id="phone_no" placeholder="Phone number" required>
                                    </div>
                                    <div class="col-md-1"></div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-md-1"></div>
                                    <label for="card_no" class="col-md-2 col-form-label">Card Number</label>
                                    <div class="col-md-8 wow pulse">
                                        <input type="text" name="card_no" data-parsley-maxlength="30" value="{{old('card_no')}}" class="form-control"
                                               id="card_no" placeholder="Card number">
                                    </div>
                                    <div class="col-md-1"></div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-md-1"></div>
                                    <div class="col-md-2">
                                        <label for="image" class="col-form-label "> Select Image </label>
                                    </div>
                                    <div class="col-md-8 wow pulse">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" id="imgInp" name="user_image">
                                            <label class="custom-file-label" for="customFile">Choose Image</label>
                                        </div>
                                        <img id="blah" class="rounded" src="#" alt="Images" width="150px" height="120px" style="display: none;">
                                    </div>
                                    <div class="col-md-1"></div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-md-1"></div>
                                    <label for="address" class="col-md-2 col-form-label ">Address</label>
                                    <div class="col-md-8 wow pulse">
                                        <textarea class="form-control" name="address" id="address" data-parsley-minlength="10" data-parsley-maxlength="100" placeholder="Address">{{old('address')}}</textarea>
                                    </div>
                                    <div class="col-md-1"></div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-md-1"></div>
                                    <label for="country" class="col-md-2 col-form-label ">Country</label>
                                    <div class="col-md-8 wow pulse">
                                        <input type="text" name="country"  class="form-control" value="{{old('country')}}"
                                               id="country" placeholder="Country">
                                    </div>
                                    <div class="col-md-1"></div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-md-1"></div>
                                    <label for="city" class="col-md-2 col-form-label ">City</label>
                                    <div class="col-md-8 wow pulse">
                                        <input type="text" name="city"  class="form-control" value="{{old('city')}}"
                                               id="city" placeholder="City">
                                    </div>
                                    <div class="col-md-1"></div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-md-1"></div>
                                    <label for="state" class="col-md-2 col-form-label ">State</label>
                                    <div class="col-md-8 wow pulse">
                                        <input type="text" name="state" class="form-control" value="{{old('state')}}"
                                               id="state" placeholder="State">
                                    </div>
                                    <div class="col-md-1"></div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-md-1"></div>
                                    <label for="zip_code" class="col-md-2 col-form-label ">Zip Code</label>
                                    <div class="col-md-8 wow pulse">
                                        <input type="text" name="zip_code"  class="form-control" value="{{old('zip_code')}}"
                                               id="zip_code" placeholder="Post Code" >
                                    </div>
                                    <div class="col-md-1"></div>
                                </div>

                                <div class="form-group row vendor-btn-top">
                                    <div class="col-md-12 text-center">
                                        <button class="vendor-btn" type="submit" class="btn btn-primary waves-effect waves-light">
                                            <b>Add</b>
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
    </div>  <!-- content-page-->


    <script type="text/javascript">
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
            $('#blah').show();
            readURL(this);
        });
    </script>

@endsection
