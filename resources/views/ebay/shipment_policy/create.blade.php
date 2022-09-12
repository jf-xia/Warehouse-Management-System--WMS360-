@extends('master')
@section('content')

    <link rel="stylesheet" href="{{asset('assets/plugins/summernote/summernote-bs4.css')}}"  />
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
                            <p>Add Shipment Policy</p>
                        </div>
                    </div>
                </div>

                @if ($message = Session::get('success'))
                    <div class="alert alert-success alert-block">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                        <strong>{{ $message }}</strong>
                    </div>
                @endif


                @if ($message = Session::get('error'))
                    <div class="alert alert-danger alert-block">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                        <strong>{{ $message }}</strong>
                    </div>
                @endif

                <div class="row m-t-20">
                    <div class="col-md-12">
                        <div class="card-box shadow">


                            <form role="form" class="vendor-form mobile-responsive" action= {{URL::to('shipment-policy')}} method="post">
                                @csrf
                                <div class="form-group row">
                                    <label for="name" class="col-md-2 col-form-label required">Shipment ID</label>
                                    <div class="col-md-10 wow pulse">
                                        <input id="shipment_id" type="text" class="form-control @error('shipment_id') is-invalid @enderror" name="shipment_id" value="" maxlength="80" onkeyup="Count();" required autocomplete="shipment_id" autofocus>
                                        <span id="display" class="float-right"></span>
                                        @error('shipment_id')
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>

                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="name" class="col-md-2 col-form-label required">Shipment Name</label>
                                    <div class="col-md-10 wow pulse">
                                        <input id="shipment_name" type="text" class="form-control @error('shipment_name') is-invalid @enderror" name="shipment_name" value="" maxlength="80" onkeyup="Count();" required autocomplete="shipment_name" autofocus>
                                        <span id="display" class="float-right"></span>
                                        @error('shipment_name')
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>

                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="category" class="col-md-2 col-form-label required">Site Name</label>
                                    <div class="col-md-10 wow pulse">
                                        <select id="site_id" class="form-control select2 @error('site_id') is-invalid @enderror"  name="site_id"  required autocomplete="site_id" autofocus>
                                            @foreach($sites as $site)
                                                <option value="{{$site->id}}">{{$site->name}}</option>
                                            @endforeach
                                        </select>
                                        @error('site')
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>

                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="category" class="col-md-2 col-form-label required">Account Name</label>
                                    <div class="col-md-10 wow pulse">
                                        <select id="account_id" class="form-control select2 @error('account_id') is-invalid @enderror"  name="account_id"  required autocomplete="account_id" autofocus>
                                            @foreach($accounts as $account)
                                                <option value="{{$account->id}}">{{$account->account_name}}</option>
                                            @endforeach
                                        </select>
                                        @error('site')
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>

                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="return_description" class="col-md-2 col-form-label required">Shipment Description</label>
                                    <div class="col-md-10 wow pulse">
                                        <textarea name="shipment_description" class="w-100 form-control" autocomplete="shipment_description" autofocus></textarea>

                                        <span id="display" class="float-right"></span>
                                        @error('shipment_description')
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>

                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row vendor-btn-top">
                                    <div class="col-md-12 text-center">
                                        <button class="draft-pro-btn" type="submit" class="btn btn-primary waves-effect waves-light">
                                            <b> Add </b>
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
    </div>  <!-- content page -->

    <!----- ckeditor summernote ------->
    <script src="{{asset('assets/ckeditor/ckeditor.js')}}"></script>

    <script>
        $('.select2').select2();
    </script>

@endsection
