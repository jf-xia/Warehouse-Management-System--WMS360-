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
                <div class="wms-breadcrumb">
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


                                <div class="col-lg-12">
                                    <div class="tabs-vertical-env parent_report_tab">
                                        <ul class="nav nav-tabs">
                                            <li class="nav-item">
                                                <a href="#parent_catalogue" data-toggle="tab" aria-expanded="false" class="nav-link active show">
                                                    Catalogue
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="#customer" data-toggle="tab" aria-expanded="true" class="nav-link">
                                                    Customer
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="#supplier" data-toggle="tab" aria-expanded="false" class="nav-link">
                                                    Supplier
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="#catalogue" data-toggle="tab" aria-expanded="false" class="nav-link">
                                                    Catalogue
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="#account" data-toggle="tab" aria-expanded="false" class="nav-link">
                                                    Account
                                                </a>
                                            </li>
                                        </ul>

                                        <div class="tab-content" id="inner_tab_parent">
                                            <div class="tab-pane active show" id="parent_catalogue">
                                                <div class="col-lg-12">
                                                    <div class="tabs-vertical-env">
                                                        <ul class="nav tabs-vertical">
                                                            <li class="nav-item">
                                                                <a href="#unsold_catalogue_sku" data-toggle="tab" aria-expanded="false" class="nav-link active show">
                                                                    Unsold SKU
                                                                </a>
                                                            </li>
                                                            <li class="nav-item">
                                                                <a href="#unsold_catalogue" data-toggle="tab" aria-expanded="true" class="nav-link">
                                                                    Unsold Catalogue
                                                                </a>
                                                            </li>
                                                        </ul>

                                                        <div class="tab-content main_report_body">
                                                            <div class="tab-pane active show" id="unsold_catalogue_sku">
                                                                <form action="{{url('global_reports/unsold_catalogue_sku_report')}}" method="get">
                                                                    @include('reports.unsold_sku')
                                                                </form>

                                                            </div>
                                                            <div class="tab-pane" id="unsold_catalogue">
                                                                <form action="{{url('global_reports/unsold_catalogue_report')}}" method="get">
                                                                    @include('reports.unsold_catalogue')
                                                                </form>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="tab-pane" id="customer">
                                                    <div class="col-lg-12">
                                                        <div class="tabs-vertical-env">
                                                            <ul class="nav tabs-vertical">
                                                                <li class="nav-item">
                                                                    <a href="#customer_list" data-toggle="tab" aria-expanded="false" class="nav-link active show">
                                                                        Customer List
                                                                    </a>
                                                                </li>
                                                            </ul>

                                                            <div class="tab-content main_report_body">
                                                                <div class="tab-pane active show" id="customer_list">
                                                                    <form action="#">
                                                                        <div class="row">
                                                                            <div class="col-md-6">
                                                                                <div class="form-group m-b-20">
                                                                                    <label>Reports Starts From</label>
                                                                                    <input type="date" name="start_date" class="form-control cus_start_date mb-1">
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-6">
                                                                                <div class="form-group m-b-20">
                                                                                    <label>Reports End Date</label>
                                                                                    <input type="date" name="start_date" class="form-control cus_start_date mb-1">
                                                                                </div>
                                                                            </div>



                                                                        </div>
                                                                    </form>

                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                            </div>
                                            <div class="tab-pane" id="supplier">
                                                <div class="col-lg-12">
                                                    <div class="tabs-vertical-env">
                                                        <ul class="nav tabs-vertical">
                                                            <li class="nav-item">
                                                                <a href="#supplier_list" data-toggle="tab" aria-expanded="false" class="nav-link active show">
                                                                    Supplier List
                                                                </a>
                                                            </li>
                                                        </ul>

                                                        <div class="tab-content main_report_body">
                                                            <div class="tab-pane active show" id="supplier_list">
                                                                <form action="#">
                                                                    <div class="row">
                                                                        <div class="col-md-6">
                                                                            <div class="form-group m-b-20">
                                                                                <label>Reports Starts From</label>
                                                                                <input type="date" name="start_date" class="form-control cus_start_date mb-1">
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-6">
                                                                            <div class="form-group m-b-20">
                                                                                <label>Reports End Date</label>
                                                                                <input type="date" name="start_date" class="form-control cus_start_date mb-1">
                                                                            </div>
                                                                        </div>



                                                                    </div>
                                                                </form>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>



                        </div> <!--//End card-box -->
                    </div><!--//End col-md-12 -->
                </div><!--//End row -->
            </div> <!-- // End Container-fluid -->
        </div> <!-- // End Content -->
    </div> <!-- // End Contact page -->
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script>
        // Select option dropdown
        $('.select2').select2();
        $(".unsold_cat_sku_account").select2({
            placeholder: "All Account",
        });

    </script>

@endsection
