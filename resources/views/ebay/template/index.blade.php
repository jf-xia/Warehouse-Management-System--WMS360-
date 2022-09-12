
@extends('master')

@section('title')
    eBay Template | WMS360
@endsection

@section('content')

    <!-- Custombox -->
    <link href="{{asset('assets/plugins/custombox/css/custombox.css')}}" rel="stylesheet">

    <!-- Modal-Effect -->
    <script src="{{asset('assets/plugins/custombox/js/custombox.min.js')}}"></script>
    <script src="{{asset('assets/plugins/custombox/js/legacy.min.js')}}"></script>



    <style>
        #div1, #div2 {
            float: left;
            width: 100px;
            height: 35px;
            margin: 10px;
            padding: 10px;
            border: 1px solid black;
        }
    </style>
    <script>
        function allowDrop(ev) {
            ev.preventDefault();
        }

        function drag(ev) {
            ev.dataTransfer.setData("text", ev.target.id);
        }

        function drop(ev) {
            ev.preventDefault();
            var data = ev.dataTransfer.getData("text");
            ev.target.appendChild(document.getElementById(data));
        }
    </script>

    <div class="content-page">
        <!-- Start content -->
        <div class="content">
            <div class="container-fluid">

                <div class="wms-breadcrumb">
                    <ol class="breadcrumb page-breadcrumb">
                        <li class="breadcrumb-item">eBay</li>
                        <li class="breadcrumb-item active" aria-current="page">Template List</li>
                    </ol>
                    <div class="breadcrumbRightSideBtn">
                        <a href="#addTemplate" data-animation="slit" data-plugin="custommodal" data-overlaySpeed="100" data-overlayColor="#36404a"><button class="btn btn-default waves-effect waves-light">Add eBay Template</button></a>
                    </div>
                </div>

                <div class="row m-t-20">
                    {{--                    <div id="div1" ondrop="drop(event)" ondragover="allowDrop(event)">--}}
                    {{--                        <img src="img_w3slogo.gif" draggable="true" ondragstart="drag(event)" id="drag1" width="88" height="31">--}}
                    {{--                    </div>--}}
                    {{--                    <div id="div2" ondrop="drop(event)" ondragover="allowDrop(event)"></div>--}}
                    <div class="col-md-12">
                        <div class="card-box ebay ebay-card-box table-responsive shadow">


                            @if (Session::has('attribute_delete_success_msg'))
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    {!! Session::get('attribute_delete_success_msg') !!}
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif


                            @if ($message = Session::get('success'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    {!! Session::get('success') !!}
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif

                            @if ($message = Session::get('error'))
                                <div class="alert alert-danger alert-block">
                                    <button type="button" class="close" data-dismiss="alert">×</button>
                                    <strong>{{ $message }}</strong>
                                </div>
                            @endif



                            <table class="ebay-table ebay-table-n w-100 table-primary-btm">
                                <thead>
                                <tr>
                                    <th class="w-75">Template Name</th>
                                    <th class="w-25">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @isset($results)
                                    @foreach($results as $result)
                                        <tr>
                                            <td class="w-75">{{$result->template_name}}</td>
                                            <td class="actions w-25">

                                                <div class="action-1 align-items-center">
                                                    <div class="align-items-center mr-2">
                                                        <a class="btn-size edit-btn" href="#editTemplateList{{$result->id}}" data-animation="slit" data-plugin="custommodal" data-overlaySpeed="100" data-overlayColor="#36404a" data-placement="top" title="Edit"><i class="fa fa-edit" aria-hidden="true"></i></a>
{{--                                                        <a class="btn-size edit-btn" href="{{URL::to('ebay-template/'.$result->id.'/edit')}}" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-edit" aria-hidden="true"></i></a>&nbsp;--}}
                                                    </div>
                                                    {{--                                                <a href="{{url('attribute/'.$attribute->id)}}" ><button class="vendor_btn_view btn-success">View</button></a>&nbsp;--}}
                                                    <div class="align-items-center">
                                                        <form action="{{url('ebay-template/'.$result->id)}}" method="post">
                                                            @method('DELETE')
                                                            @csrf
{{--                                                            <a href="#" class="on-default remove-row" ><button class="vendor_btn_delete btn-danger" onclick="return check_delete('attribute');">Delete</button>  </a>--}}
                                                            <button class="del-pub del-pub-n delete-btn on-default remove-row" style="cursor: pointer" data-toggle="tooltip" data-placement="top" title="Delete" onclick="return check_delete('attribute');"><i class="fa fa-trash" aria-hidden="true"></i></button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>


                                        <!-- Edit Template Modal -->
                                        <div id="editTemplateList{{$result->id}}" class="modal-demo">
                                            <button type="button" class="close" onclick="Custombox.close();">
                                                <span>&times;</span><span class="sr-only">Close</span>
                                            </button>
                                            <h4 class="custom-modal-title">Edit eBay Template</h4>
                                            <form role="form" class="vendor-form mobile-responsive" action="{{URL::to('ebay-template/'.$result->id)}}" method="post">
                                                @method('PUT')
                                                @csrf
                                                <div class="form-group row">
                                                    <div class="col-md-1"></div>
                                                    <label for="template_name" class="col-md-3 col-form-label ml-sm-25 mr-sm-25 ml-xs-25 mr-xs-25 required">Template Name</label>
                                                    <div class="col-md-7 ml-sm-25 mr-sm-25 ml-xs-25 mr-xs-25">
                                                        <input id="template_name" type="text" class="form-control @error('template_name') is-invalid @enderror" name="template_name" value="{{$result->template_name}}" maxlength="80" onkeyup="Count();" required autocomplete="template_name" autofocus>
                                                        <span id="display" class="float-right"></span>
                                                        @error('template_name')
                                                        <span class="invalid-feedback" role="alert">
                                                             <strong>{{ $message }}</strong>
                                                        </span>
                                                        @enderror
                                                    </div>
                                                    <div class="col-md-1"></div>
                                                </div>


                                                <div class="form-group row">
                                                    <div class="col-md-1"></div>
                                                    <label for="Category" class="col-md-3 col-form-label ml-sm-25 mr-sm-25 ml-xs-25 mr-xs-25 required">
                                                        Revise Option</label>
                                                            <div class="col-md-7 ml-sm-25 mr-sm-25 ml-xs-25 mr-xs-25">
                                                                <select name='revise_flag' class="form-control" required>
                                                                    <option value="" selected>Revise Option</option>
                                                                    <option value="1">Apply Revise</option>
                                                                    <option value="">Don't Apply Revise</option>
                                                                </select>
                                                            </div>
                                                    <div class="col-md-1"></div>
                                                </div>


                                                <div class="form-group row">
                                                    <div class="col-md-1"></div>
                                                    <label for="template_html" class="col-md-3 col-form-label ml-sm-25 mr-sm-25 ml-xs-25 mr-xs-25 required">Template description</label>
                                                    <div class="col-md-7 ml-sm-25 mr-sm-25 ml-xs-25 mr-xs-25">
                                                        <textarea name="template_html" class="w-100 form-control" autocomplete="template_html" autofocus>{{$result->template_html}}</textarea>
                                                        <span id="display" class="float-right"></span>
                                                        @error('template_html')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                        @enderror
                                                    </div>
                                                    <div class="col-md-1"></div>
                                                </div>

                                                <div class="form-group row">
                                                    <div class="col-md-12 text-center mb-5 mt-4">
                                                        <button type="submit" class="btn btn-primary vendor-btn waves-effect waves-light">
                                                            <b>Update</b>
                                                        </button>
                                                    </div>
                                                </div>

                                            </form>
                                        </div>
                                        <!--End Edit Template Modal -->


                                    @endforeach
                                @endisset
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div> <!-- end row -->
            </div> <!-- container -->
        </div> <!-- content -->

    </div>


    <!-- Add Template Modal -->
    <div id="addTemplate" class="modal-demo">
        <button type="button" class="close" onclick="Custombox.close();">
            <span>&times;</span><span class="sr-only">Close</span>
        </button>
        <h4 class="custom-modal-title">Add eBay Template</h4>

        <form role="form" class="vendor-form mobile-responsive" action="{{URL::to('ebay-template')}}" method="post" enctype="multipart/form-data" >
            @csrf

            <div class="form-group row">
                <div class="col-md-1"></div>
                <label for="name" class="col-md-3 col-form-label ml-sm-25 mr-sm-25 ml-xs-25 mr-xs-25 required">Template Name</label>
                <div class="col-md-7 ml-sm-25 mr-sm-25 ml-xs-25 mr-xs-25">
                    <input id="template_name" type="text" class="form-control @error('template_name') is-invalid @enderror" name="template_name" value="" maxlength="80" onkeyup="Count();" required autocomplete="template_name" autofocus>
                    <span id="display" class="float-right"></span>
                    @error('template_name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="col-md-1"></div>
            </div>

            <div class="form-group row">
                <div class="col-md-1"></div>
                <label for="return_description" class="col-md-3 col-form-label ml-sm-25 mr-sm-25 ml-xs-25 mr-xs-25 required">Template description</label>
                <div class="col-md-7 ml-sm-25 mr-sm-25 ml-xs-25 mr-xs-25">
                    <textarea name="template_html" class="w-100 form-control" autocomplete="template_html" autofocus></textarea>
                    <span id="display" class="float-right"></span>
                    @error('template_html')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="col-md-1"></div>
            </div>

            <div class="form-group row">
                <div class="col-md-12 text-center mb-5 mt-4">
                    <button type="submit" class="btn btn-primary vendor-btn waves-effect waves-light">
                        <b>Add</b>
                    </button>
                </div>
            </div>

        </form>
    </div>
    <!--End Template Modal -->


@endsection
