
@extends('master')

@section('title')
    App URL Setting | WMS360
@endsection

@section('content')
    <div class="content-page">
        <!-- Start content -->
        <div class="content">
            <div class="container-fluid">

                <div class="d-flex justify-content-center align-items-center">
                    <div>
                        <ol class="breadcrumb page-breadcrumb">
                            <li class="breadcrumb-item active" aria-current="page">App URL Setting</li>
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

                            @if (Session::has('msg'))
                                <div class="alert alert-success">
                                    {!! Session::get('msg') !!}
                                </div>
                            @endif

                            @if(!isset($url_info) && $status == 'add')

                            <form role="form" class="vendor-form" action="{{url('app-url-setting')}}" method="post">
                                @csrf
                                <div class="form-group row">
                                    <div class="col-md-1"></div>
                                    <label for="name" class="col-md-2 col-form-label required">Url Name</label>
                                    <div class="col-md-8">
                                        <input type="text" name="url" class="form-control" id="url" value="{{ old('url') }}" placeholder="" required>
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
                            <hr/>
                            @endif

                                @if(isset($url_info) && $status == 'edit')
                                    <div class="text-center">
                                        <h5>Edit App URL</h5>
                                    </div>
                                    <form role="form" class="vendor-form" action="{{url('app-url-setting/'.$url_info->id)}}" method="post">
                                        @method('PUT')
                                        @csrf
                                        <div class="form-group row">
                                            <div class="col-md-1"></div>
                                            <label for="name" class="col-md-2 col-form-label required">URL Name</label>
                                            <div class="col-md-8">
                                                <input type="text" name="url" class="form-control" id="url" value="{{$url_info->url}}" placeholder="" required>
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
                                    </form><hr/>
                                @endif


{{--                            <div class="text-center">--}}
{{--                                <h5>App Url</h5>--}}
{{--                            </div>--}}
                            <table class="product-table w-100">
                                <thead>
                                <tr>
                                    <th>URL</th>
                                    <th>Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                @isset($url_info)
                                    <tr>
                                        <td>{{$url_info->url}}</td>
                                        <td>
                                            <div class="action-1">
                                                <a href="{{url('app-url-setting/'.$url_info->id.'/edit')}}"><button class="btn-size edit-btn mr-2" style="cursor: pointer;"><i class="fa fa-edit" aria-hidden="true"></i></button></a>&nbsp;
                                                <form action="{{url('app-url-setting/'.$url_info->id)}}" method="post">
                                                    @method('DELETE')
                                                    @csrf
                                                    <a href="#" class="on-default remove-row" ><button class="btn-size delete-btn" style="cursor: pointer;" onclick="return check_delete('shelf');"><i class="fa fa-trash" aria-hidden="true"></i></button>  </a>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endisset
                                </tbody>
                            </table>
                        </div>  <!-- card-box -->
                    </div> <!-- end col -->
                </div>
                <!-- end row -->
            </div> <!-- container -->

        </div> <!-- content -->

    </div>
@endsection
