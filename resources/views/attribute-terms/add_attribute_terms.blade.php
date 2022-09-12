
@extends('master')
@section('content')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>

    <div class="content-page">
        <!-- Start content -->
        <div class="content">
            <div class="container-fluid">

                <!-- Page-Title -->
                <div class="row">
                    <div class="col-md-12 text-center">
                        <div class="vendor-title">
                            <p>Add Attribute Terms</p>
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
                            @if (Session::has('attribute_terms_add_success_msg'))
                                <div class="alert alert-success">
                                    {!! Session::get('attribute_terms_add_success_msg') !!}
                                </div>
                            @endif

                            @if (Session::has('attribute_terms_add_error_msg'))
                                <div class="alert alert-danger">
                                    {!! Session::get('attribute_terms_add_error_msg') !!}
                                </div>
                            @endif

                            <form role="form" class="vendor-form mobile-responsive" action="{{url('attribute-terms')}}" method="post">
                                @csrf
                                <div class="form-group row">
                                    <div class="col-md-1"></div>
                                    <label for="name" class="col-md-3 col-form-label required">Attribute</label>
                                    <div class="col-md-7 wow pulse">
                                        <select name="attribute_id" id="attribute_id" class="form-control select2" required>
                                            <option value="">Select Attribute</option>
                                            @isset($all_attribute)
                                                @foreach($all_attribute as $attribute)
                                                    <option value="{{$attribute->id}}">{{$attribute->attribute_name}}</option>
                                                @endforeach
                                            @endisset
                                        </select>
                                    </div>
                                    <div class="col-md-1"></div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-1"></div>
                                    <label for="name" class="col-md-3 col-form-label required">Attribute Terms Name</label>
                                    <div class="col-md-7 wow pulse">
                                        <input type="text" name="terms_name" class="form-control" id="terms_name" value="{{ old('terms_name') }}" placeholder="Enter attribute terms name" required>
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
    <script>
        $('.select2').select2();
    </script>
@endsection
