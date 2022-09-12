
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
                            <p>Edit Attribute Terms</p>
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
                            @if (Session::has('attribute_terms_edit_success_msg'))
                                <div class="alert alert-success">
                                    {!! Session::get('attribute_terms_edit_success_msg') !!}
                                </div>
                            @endif

                            <form role="form" class="vendor-form mobile-responsive" action="{{url('attribute-terms/'.$single_attribute_terms->id)}}" method="post">
                                @method('PUT')
                                @csrf

                                <div class="form-group row">
                                    <div class="col-md-1"></div>
                                    <label for="name" class="col-md-3 col-form-label required">Attribute Terms Name</label>
                                    <div class="col-md-7">
                                        <input type="text" name="terms_name" class="form-control" id="terms_name" value="{{ $single_attribute_terms->terms_name ? $single_attribute_terms->terms_name : old('terms_name') }}" placeholder="Enter attribute terms name" required>
                                    </div>
                                    <div class="col-md-1"></div>
                                </div>
                                <input type="hidden" name="attribute_id" value="{{$single_attribute_terms->attribute_id}}">
                                <div class="form-group row vendor-btn-top">
                                    <div class="col-md-12 text-center">
                                        <button class="vendor-btn" type="submit" class="btn btn-primary waves-effect waves-light">
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
