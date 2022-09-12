@extends('layouts.login_master')

@section('content')
    <!-- <div class="account-pages" style="background-image:url('https://localhost/wms/assets/images/WMS2.jpg'); "></div> -->
    <div class="account-pages" style="background-image: url('{{ asset('assets/common-assets/WMS.jpg')}}');background-position: center;background-repeat: no-repeat;background-size: cover;"></div>
    <div class="clearfix"></div>

    <div class="wrapper-page">
        <div class="card-box login-cardbox">
            <div class="d-flex justify-content-center pt-3 pb-1">
                <img src="{{isset($logo) ? $logo : asset('assets/common-assets/WMS_360.png')}}" alt="app-logo" style="width: 120px; height: auto;">
            </div>
            <div class="panel-heading">
                <h4 class="text-center"> Sign In to <strong class="text-custom">WMS</strong></h4>
            </div>

            <div class="p-20">
                <form class="form-horizontal m-t-20" method="post" action="{{ route('login') }}">
                @csrf
                    <div class="form-group">
                        <div class="">
                            <input class="form-control" type="text" name="email" value="{{ old('email') }}" required="" placeholder="Username">
                            @if ($errors->has('email'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="">
                            <input id="password-field" class="form-control" type="password" name="password" required="" placeholder="Password">
                            <span toggle="#password-field" class="fa fa-fw fa-eye field-icon toggle-password"></span>
                            @if ($errors->has('password'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group ">
                        <div>
                            <div class="checkbox checkbox-custom">
                                <input id="checkbox-signup" type="checkbox">
                            {{--<input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>--}}
                                <label for="checkbox-signup"> Remember me </label>
                            </div>

                        </div>
                    </div>



                    <div class="form-group text-center m-t-40">
                        <div class="">
                            <button class="btn btn-default btn-block text-uppercase waves-effect waves-light" type="submit">
                                Log In
                            </button>
                        </div>
                    </div>

{{--                    <div class="form-group m-t-20 m-b-0">--}}
{{--                        <div class="">--}}
{{--                            <a href="{{ route('password.request') }}" class="text-dark"><i class="fa fa-lock m-r-5"></i> Forgot your password?</a>--}}
{{--                            <p class="m-t-20">--}}
{{--                                Don't have an account? <a href="{{ route('register') }}" class="m-l-5" style="color: #7e57c2"><b>Sign Up</b></a>--}}
{{--                            </p>--}}
{{--                        </div>--}}
{{--                    </div>--}}



{{--                    <div class="form-group m-t-20 m-b-0">--}}
{{--                        <div class=" text-center">--}}
{{--                            <h5 class="sign-font"><b>Sign in with</b></h5>--}}
{{--                        </div>--}}
{{--                    </div>--}}

{{--                    <div class="form-group m-b-0 text-center">--}}
{{--                        <div class="">--}}
{{--                            <button type="button" class="btn btn-sm btn-facebook waves-effect waves-light m-t-20">--}}
{{--                                <i class="fa fa-facebook m-r-5"></i> Facebook--}}
{{--                            </button>--}}

{{--                            <button type="button" class="btn btn-sm btn-twitter waves-effect waves-light m-t-20">--}}
{{--                                <i class="fa fa-twitter m-r-5"></i> Twitter--}}
{{--                            </button>--}}

{{--                            <button type="button" class="btn btn-sm btn-googleplus waves-effect waves-light m-t-20">--}}
{{--                                <i class="fa fa-google-plus m-r-5"></i> Google+--}}
{{--                            </button>--}}
{{--                        </div>--}}
{{--                    </div>--}}
                </form>

            </div>
        </div>
{{--        <div class="row">--}}
{{--            <div class=" text-center">--}}
{{--                <p class="m-l-10">--}}
{{--                    Don't have an account? <a href="{{ route('register') }}" class="text-primary m-l-5"><b>Sign Up</b></a>--}}
{{--                </p>--}}
{{--            </div>--}}
{{--        </div>--}}

    </div>

    <!-- Bootstrap Js--->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <!-- // End Bootstrap Js--->

    <!--- Toggle Sign In View Password start--->
    <script>
        $(".toggle-password").click(function() {

            $(this).toggleClass("fa-eye fa-eye-slash");
            var input = $($(this).attr("toggle"));
            if (input.attr("type") == "password") {
                input.attr("type", "text");
            } else {
                input.attr("type", "password");
            }
        });
    </script>
    <!---// End Toggle Sign In View Password --->

@endsection
