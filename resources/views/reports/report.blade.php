@extends('master')
@section('title')
    Catalogue | Reports | WMS360
@endsection
@section('content')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
    <link rel="stylesheet" href="{{asset('assets/css/loader.css')}}">
    <div class="content-page">
        <!-- Start content -->
        <div class="content">
            <div class="container-fluid">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <ol class="breadcrumb page-breadcrumb">
                            <li class="breadcrumb-item">Catalogue</li>
                            <li class="breadcrumb-item active" aria-current="page">Reports</li>
                        </ol>
                    </div>
                </div>
                <div class="row m-t-20 report">
                    <div class="col-md-12">
                        <div class="card-box py-5 shadow">
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
                            <div class="container" id="report_data">
                                <div class="row">
                                    <h5>Export Catalogue As CSV</h5>
                                </div>
                                <hr>
                                <form action="#">
                                <div class="row">
                                    <div class="col-md-2">
                                        <label for="status">Status</label>
                                        <select name="status" class="form-control select2" id="status">
                                            <option value="">Select Status</option>
                                            <option value="publish" selected>Active</option>
                                            <option value="draft">Draft</option>
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <label for="type">Type</label>
                                        <select name="type" class="form-control select2" id="type">
                                            <option value="">Select Type</option>
                                            <option value="variable">Variable</option>
                                            <option value="simple">Simple</option>
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <label for="channel">Channel</label>
                                        <select name="channel[]" class="form-control select2" id="channel" multiple>
                                            <option value="">Select Channel</option>
                                            @isset($channels)
                                                @foreach($channels as $channel => $accounts)
                                                    @if(count($accounts) > 0)
                                                        @foreach ($accounts as $account)
                                                            <option value="{{$channel}}/{{$account}}">{{$channel}}/{{$account}}</option>
                                                        @endforeach
                                                    @endif
                                                @endforeach()
                                            @endisset
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <label for="category">Category</label>
                                        <select name="category[]" class="form-control select2" id="category" multiple>
                                            <option value="">Select Category</option>
                                            @isset($wmsCategoryLists)
                                                @foreach($wmsCategoryLists as $category)
                                                    <option value="{{$category->id}}">{{$category->category_name}}</option>
                                                @endforeach()
                                            @endisset
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <label for="stock">Availability</label>
                                        <select name="stock" class="form-control select2" id="stock">
                                            <option value="">Select Availability</option>
                                            <option value="instock">In Stock</option>
                                            <option value="outofstock">Out Of Stock</option>
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <label for=""></label>
                                        <button type="button" class="btn btn-info form-control catalogue-export-as-csv">
                                            <i class="loading-icon fa-lg fas fa-spinner fa-spin hide"></i> &nbsp;
                                            <span class="btn-txt">Export CSV</span>
                                        </button>
                                    </div>
                                </div>
                                </form>
                            </div>
                        </div>   <!--//End card-box -->
                    </div><!--//End col-md-12 -->
                </div><!--//End row -->
            </div> <!-- // End Container-fluid -->
        </div> <!-- // End Content -->
    </div> <!-- // End Contact page -->
    <script>
        // Select option dropdown
        $('.select2').select2();
        $("#channel").select2({
            placeholder: "Select Channel",
        });
        $("#category").select2({
            placeholder: "Select Category",
        });
        $('.catalogue-export-as-csv').on('click',function(){
            var formData = $("form").serializeArray();
            $.ajax({
                type: "post",
                url: "{{url('export-catalogue-csv')}}",
                dataType: 'json',
                data: formData,
                beforeSend: function (){
                    $(".catalogue-export-as-csv .loading-icon").removeClass("hide");
                    $(".catalogue-export-as-csv").attr("disabled", true);
                    $(".catalogue-export-as-csv .btn-txt").text("Processing ...");
                },
                success: function (response) {
                    if(response.type == 'success'){
                        const link = document.createElement('a');
                        link.href = response.url;
                        link.setAttribute('download',response.file_name);
                        document.body.appendChild(link);
                        link.click();

                    }else{
                        Swal.fire('Oops!',response.message,'error')
                    }
                    $(".catalogue-export-as-csv .loading-icon").addClass("hide");
                    $(".catalogue-export-as-csv").attr("disabled", false);
                    $(".catalogue-export-as-csv .btn-txt").text("Export CSV");
                },
                complete: function (data) {

                }
            })
        });

    </script>

@endsection
