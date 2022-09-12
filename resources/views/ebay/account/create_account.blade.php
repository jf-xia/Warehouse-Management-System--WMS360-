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
                            <p>Add Ebay Account</p>
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


                            <form role="form" class="vendor-form mobile-responsive" action= {{URL::to('ebay-create-account')}} method="post">
                                @csrf

                                <div class="form-group row">
                                    <label for="name" class="col-md-2 col-form-label required">Ebay User Name</label>
                                    <div class="col-md-10 wow pulse">
                                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="account_name" value="" maxlength="80" onkeyup="Count();" required autocomplete="name" autofocus>
                                        <span id="display" class="float-right"></span>
                                        @error('name')
                                        <span class="invalid-feedback" role="alert"></span>
                                        <strong>{{ $message }}</strong>

                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="name" class="col-md-2 col-form-label required">Feeder Quantity</label>
                                    <div class="col-md-10 wow pulse">
                                        <input id="feeder_quantity" type="text" class="form-control @error('feeder_quantity') is-invalid @enderror" name="feeder_quantity" value="" maxlength="80" onkeyup="Count();" required autocomplete="feeder_quantity" autofocus>
                                        <span id="display" class="float-right"></span>
                                        @error('name')
                                        <span class="invalid-feedback" role="alert"></span>
                                        <strong>{{ $message }}</strong>

                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="category" class="col-md-2 col-form-label required">Site</label>
                                    <div class="col-md-10 wow pulse">
                                        <select id="site_id" class="form-control select2 @error('site') is-invalid @enderror" multiple="multiple" name="site_id[]" value="{{ old('site_id') }}" required autocomplete="site_id" autofocus>
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
                                    <label for="category" class="col-md-2 col-form-label required">Developer Account</label>
                                    <div class="col-md-10 wow pulse">
                                        <select id="developer_id" class="form-control select2 @error('developer_id') is-invalid @enderror"  name="developer_id" value="{{ old('developer_id') }}" required autocomplete="developer_id" autofocus>
                                            @foreach($developer_accounts as $developer_account)
                                                <option value="{{$developer_account->id}}">{{$developer_account->client_id}}</option>
                                            @endforeach
                                        </select>
                                        @error('developer_id')
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
