
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
                            <p>Edit User</p>
                        </div>
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
                            @if (Session::has('user_update_success_msg'))
                                <div class="alert alert-success">
                                    {!! Session::get('user_update_success_msg') !!}
                                </div>
                            @endif
                            <form role="form" class="vendor-form mobile-responsive" action="{{url('update-user/'.$single_user->id)}}" method="POST" enctype="multipart/form-data">
                                @csrf
{{--                                <input type="hidden" name="_method" value="PUT">--}}
{{--                                <input type="hidden" name="_token" value="">--}}
                                <div class="form-group row">
                                    <div class="col-md-1"></div>
                                    <label for="image" class="col-md-2 col-form-label">Select Image</label>
                                    <div class="col-md-8 wow pulse">
                                        <div class="custom-file m-b-10">
                                            <input type="file" class="custom-file-input" id="imgInp" name="user_image">
                                            <label class="custom-file-label" for="customFile">Choose image</label>
                                        </div>
                                        <img class="rounded" id="user_edit_image" src="{{asset('uploads/'.$single_user->image)}}" alt="Image" width="150px" height="120px">
                                        <img id="blah" class="rounded" src="#" alt="Images" width="150px" height="120px" style="display: none;">
                                    </div>
                                    <div class="col-md-1"></div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-1"></div>
                                    <label for="employee_id" class="col-md-2 col-form-label">Employee Id</label>
                                    <div class="col-md-8 wow pulse">
                                        <input type="text" name="employee_id" class="form-control" id="employee_id" value="{{$single_user->employee_id ? $single_user->employee_id : old('employee_id')}}" placeholder="Enter employee id">
                                    </div>
                                    <div class="col-md-1"></div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-1"></div>
                                    <label for="name" class="col-md-2 col-form-label required">First Name</label>
                                    <div class="col-md-8 wow pulse">
                                        <input type="text" name="name" class="form-control" id="name" value="{{$single_user->name ? $single_user->name : old('name')}}" placeholder="Enter First Name" required>
                                    </div>
                                    <div class="col-md-1"></div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-md-1"></div>
                                    <label for="last_name" class="col-md-2 col-form-label required">Last Name</label>
                                    <div class="col-md-8 wow pulse">
                                        <input type="text" name="last_name" class="form-control" id="last_name" value="{{$single_user->last_name ? $single_user->last_name : old('last_name')}}" placeholder="Enter Last Name" required>
                                    </div>
                                    <div class="col-md-1"></div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-1"></div>
                                    <label for="email" class="col-md-2 col-form-label required">Email</label>
                                    <div class="col-md-8 wow pulse">
                                        <input type="email" name="email" class="form-control" id="email" value="{{$single_user->email ? $single_user->email : old('email')}}" placeholder="Enter email" required>
                                    </div>
                                    <div class="col-md-1"></div>
                                </div>
                                @if(in_array('1', explode(',', Auth::user()->role)))
                                <div class="form-group row">
                                    <div class="col-md-1"></div>
                                    <label for="role" class="col-md-2 col-form-label required">Role </label>
                                    <div class="col-md-8 wow pulse d-flex align-items-center">
                                        @foreach($all_role as $role)
                                            <?php
                                            $temp = '';
                                            ?>
                                            @foreach($single_user->roles as $roles)
                                                @if($role->id == $roles->id)
                                                <input type="checkbox" name="role[]" value="{{$roles->id}}" checked>{{$roles->role_name}}
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
                                    <div class="col-md-1"></div>
                                </div>
                                @endif
                                <div class="form-group row">
                                    <div class="col-md-1"></div>
                                    <label for="phone_no" class="col-md-2 col-form-label required">Phone Number</label>
                                    <div class="col-md-8 wow pulse">
                                        <input type="text" name="phone_no" class="form-control" id="phone_no" value="{{$single_user->phone_no ? $single_user->phone_no : old('phone_no')}}" placeholder="Enter Phone Number" required>
                                    </div>
                                    <div class="col-md-1"></div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-1"></div>
                                    <label for="card_no" class="col-md-2 col-form-label ">Card Number </label>
                                    <div class="col-md-8 wow pulse">
                                        <input type="text" name="card_no" class="form-control" id="card_no" value="{{$single_user->card_no ? $single_user->card_no : old('card_no')}}" placeholder="Enter Card Number">
                                    </div>
                                    <div class="col-md-1"></div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-1"></div>
                                    <label for="address" class="col-md-2 col-form-label ">Address </label>
                                    <div class="col-md-8 wow pulse">
                                      <textarea name="address" class="form-control" id="address" value="" placeholder="Enter Addreess">{{$single_user->address ? $single_user->address : old('address')}}
                                      </textarea>
                                    </div>
                                    <div class="col-md-1"></div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-1"></div>
                                    <label for="country" class="col-md-2 col-form-label ">Country</label>
                                    <div class="col-md-8 wow pulse">
                                        <input type="text" name="country" class="form-control" id="country" value="{{$single_user->country ? $single_user->country : old('country')}}" placeholder="Enter country">
                                    </div>
                                    <div class="col-md-1"></div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-1"></div>
                                    <label for="state" class="col-md-2 col-form-label ">State</label>
                                    <div class="col-md-8 wow pulse">
                                        <input type="text" name="state" class="form-control" id="state" value="{{$single_user->state ? $single_user->country : old('state')}}" placeholder="Enter state">
                                    </div>
                                    <div class="col-md-1"></div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-1"></div>
                                    <label for="city" class="col-md-2 col-form-label ">City</label>
                                    <div class="col-md-8 wow pulse">
                                        <input type="text" name="city" class="form-control" id="city" value="{{$single_user->city ? $single_user->city : old('city')}}" placeholder="Enter city">
                                    </div>
                                    <div class="col-md-1"></div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-md-1"></div>
                                    <label for="zip_code" class="col-md-2 col-form-label ">Zip Code</label>
                                    <div class="col-md-8 wow pulse">
                                        <input type="text" name="zip_code" class="form-control" id="zip_code" value="{{$single_user->zip_code ? $single_user->zip_code : old('zip_code')}}" placeholder="Enter zip code">
                                    </div>
                                    <div class="col-md-1"></div>
                                </div>

                                <input type="hidden" name="exist_image" value="{{$single_user->image}}">

                                <div class="form-group row vendor-btn-top">
                                    <div class="col-md-12 text-center">
                                        <button class="vendor-btn" type="submit" class="btn btn-primary waves-effect waves-light">
                                            <b> Update </b>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <!-- card-box -->
                    </div>
                    <!-- end col -->
                </div>
                <!-- end row -->
            </div>
            <!-- container -->
        </div>
        <!-- content -->
    </div>
    <!-- content page-->

    <script type="text/javascript">
        $(document).ready(function() {
            $('form').parsley();
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
