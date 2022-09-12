@extends('master')

@section('title')
   Wms Category | Category List | Edit Category | WMS360
@endsection

@section('content')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
    <div class="content-page">
        <!-- Start content -->
        <div class="content">
            <div class="container-fluid">

                <div class="wms-breadcrumb-middle">
                    <div>
                        <ol class="breadcrumb page-breadcrumb">
                            <li class="breadcrumb-item" aria-current="page">Category List</li>
                            <li class="breadcrumb-item active" aria-current="page">Edit Wms Category</li>
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
                            @if (Session::has('success'))
                                <div class="alert alert-success">
                                    {!! Session::get('success') !!}
                                </div>
                            @endif

                            <form role="form" class="vendor-form mobile-responsive" action="{{url('woowms-category/'.$woowms_single_category->id)}}" method="post">
                                @method('PUT')
                                @csrf
                                
                                <div class="form-group row">
                                    <div class="col-md-1"></div>
                                    <label for="name" class="col-md-3 col-form-label required">Category Name</label>
                                    <div class="col-md-7">
                                        <input type="text" name="category_name" class="form-control" id="category_name" value="{{ $woowms_single_category->category_name ?? old('category_name') }}" placeholder="Enter Woo Wms Category name" required>
                                    </div>
                                    <div class="col-md-1"></div>
                                </div>

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
    <script>
        $('.select2').select2({
            placeholder: "Select department",
            allowClear: true
        });
    </script>
@endsection
