
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
                            <p>Edit Shelf</p>
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
                            @if (Session::has('shelf_updated_success_msg'))
                                <div class="alert alert-success">
                                    {!! Session::get('shelf_updated_success_msg') !!}
                                </div>
                            @endif

                            <form role="form" class="vendor-form mobile-responsive" action="{{url('shelf/'.$single_shelf->id)}}" method="post">
                                @method('PUT')
                                @csrf
                                <div class="form-group row">
                                    <div class="col-md-1"></div>
                                    <label for="name" class="col-md-2 col-form-label required">Shelf Name</label>
                                    <div class="col-md-8">
                                        <input type="text" name="shelf_name" class="form-control" id="shelf_name" value="{{ $single_shelf->shelf_name ? $single_shelf->shelf_name : old('shelf_name') }}" placeholder="Enter shelf name" required>
                                    </div>
                                    <div class="col-md-1"></div>
                                </div>

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
