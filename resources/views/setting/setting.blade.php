@extends('master')

@section('title')
   Table Color Settings | WMS360
@endsection

@section('content')
    <div class="content-page">
        <!-- Start content -->
        <div class="content" >
            <div class="container-fluid">


                <div class="d-flex justify-content-center align-items-center">
                    <div>
                        <ol class="breadcrumb page-breadcrumb">
                            <li class="breadcrumb-item active" aria-current="page">Table Color Settings</li>
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

                            <form id="chargeForm" class="m-t-40 mobile-responsive" role="form" action="{{route('settings.store')}}"  method="post">
                                @csrf
                                <div class="container">
                                    <div class="card p-20 m-t-10 variation-card">
                                            <div class="form-group row">
                                                <div class="col-md-6">
                                                    <div class="text-center"> <label>Page Name</label></div>
                                                    <div>
                                                        <input type="text" name="page_name[]" class="form-control" id="" value="" placeholder="">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-md-3">
                                                    <div class="text-center"> <label>Page Title</label></div>
                                                    <div>
                                                        <input type="text" name="page_title[]" class="form-control ean_class" id="ean_no" value="" placeholder="">
                                                    </div>
                                                </div>

                                                <div class="col-md-3">
                                                    <div class="text-center"> <label>Table Header Color</label></div>
                                                    <div>
                                                        <input type="text" name="table_header_color[]" value="" class="form-control" id="" placeholder="">
                                                    </div>
                                                </div>

                                                <div class="col-md-3">
                                                    <div class="text-center"> <label>Table Header Text Color</label></div>
                                                    <div>
                                                        <input type="text" name="table_header_text_color[]" value="" class="form-control" id="" placeholder="">
                                                    </div>
                                                </div>

                                            </div>
                                            <!--form-group end--> 
                                            <span>
                                            <button type="button" class="btn btn-danger remove-variation float-right">Remove</button>
                                        </span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <button type="button" class="btn btn-primary m-t-5 add-more">Add</button>
                                </div>


                                <div class="form-group row">
                                    <div class="col-md-12 text-center">
                                        <button type="submit" class="btn btn-primary vendor-btn waves-effect waves-light" >
                                            <b> Submit </b>
                                        </button>
                                    </div>
                                </div> <!--form-group end-->

                            </form> <!--END FORM-->

                        </div>  <!-- card-box -->
                    </div> <!-- end col -->
                </div>
                <!-- end row -->

            </div> <!-- container -->
        </div> <!-- content -->
    </div>  <!-- content page -->

    <script type="text/javascript">

        jQuery(document).ready(function(){

            $('.summernote').summernote({
                height: 250,                 // set editor height
                minHeight: null,             // set minimum height of editor
                maxHeight: null,             // set maximum height of editor
                focus: false                 // set focus to editable area after initializing summernote
            });

            $('.inline-editor').summernote({
                airMode: true
            });

            $('button.add-more').on('click',function () {
                console.log('do');
                var content = '<div class="card p-20 m-t-10 variation-card">\n' +
                    '                                            <div class="form-group row">\n' +
                    '                                                <div class="col-md-6">\n' +
                    '                                                    <div class="text-center"> <label>Page Name</label></div>\n' +
                    '                                                    <div>\n' +
                    '                                                        <input type="text" name="page_name[]" class="form-control" id="" value="" placeholder="">\n' +
                    '                                                    </div>\n' +
                    '                                                </div>\n' +
                    '                                            </div>\n' +
                    '                                            <div class="form-group row">\n' +
                    '                                                <div class="col-md-3">\n' +
                    '                                                    <div class="text-center"> <label>Page Title</label></div>\n' +
                    '                                                    <div>\n' +
                    '                                                        <input type="text" name="page_title[]" class="form-control ean_class" id="ean_no" value="" placeholder="">\n' +
                    '                                                    </div>\n' +
                    '                                                </div>\n' +
                    '\n' +
                    '                                                <div class="col-md-3">\n' +
                    '                                                    <div class="text-center"> <label>Table Header Color</label></div>\n' +
                    '                                                    <div>\n' +
                    '                                                        <input type="text" name="table_header_color[]" value="" class="form-control" id="" placeholder="">\n' +
                    '                                                    </div>\n' +
                    '                                                </div>\n' +
                    '\n' +
                    '                                                <div class="col-md-3">\n' +
                    '                                                    <div class="text-center"> <label>Table Header Text Color</label></div>\n' +
                    '                                                    <div>\n' +
                    '                                                        <input type="text" name="table_header_text_color[]" value="" class="form-control" id="" placeholder="">\n' +
                    '                                                    </div>\n' +
                    '                                                </div>\n' +
                    '\n' +
                    '                                            </div>\n' +
                    '                                            <!--form-group end-->\n' +
                    '                                            <span>\n' +
                    '                                            <button type="button" class="btn btn-danger remove-variation float-right">Remove</button>\n' +
                    '                                        </span>\n' +
                    '                                    </div>';
                $('.shadow form#chargeForm .container').append(content);
            });

            $('.container.remove-variation').click(function () {
                console.log('found');
                $(this).closest('.variation-card').remove();
            });

        });

    </script>


@endsection
