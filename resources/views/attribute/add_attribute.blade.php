
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
                            <p>Add Attribute</p>
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
                            @if (Session::has('attribute_add_success_msg'))
                                <div class="alert alert-success">
                                    {!! Session::get('attribute_add_success_msg') !!}
                                </div>
                            @endif

                            <form role="form" class="vendor-form mobile-responsive" action="{{url('attribute')}}" method="post">
                                @csrf
                                <div class="form-group row">
                                    <div class="col-md-1"></div>
                                    <label for="use_variation" class="col-md-2 col-form-label">Use as woocommerce variation ?</label>
                                    <div class="col-md-2">
                                        <input type="radio" name="use_variation" class="form-control" id="use_variation" value="1" > Yes
                                        <input type="radio" name="use_variation" class="form-control" id="use_variation" value="0" > No
                                    </div>
                                    <div class="col-md-1"></div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-md-1"></div>
                                    <label for="name" class="col-md-2 col-form-label">Attribute Name</label>
                                    <div class="col-md-8">
                                        <input type="text" name="attribute_name[]" class="form-control" id="attribute_name" value="{{ old('attribute_name') }}" placeholder="Enter attribute name" required>
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

    </div>
@endsection
