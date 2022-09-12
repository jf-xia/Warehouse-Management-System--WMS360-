@extends('master')

@section('title')
    Supplier List | Supplier Details | WMS360
@endsection

@section('content')

<div class="content-page">
    <!-- Start content -->
    <div class="content">
        <div class="container-fluid">


        <div class="d-flex justify-content-center align-items-center">
            <div>
                <ol class="breadcrumb page-breadcrumb">
                    <li class="breadcrumb-item">Supplier List</li>
                    <li class="breadcrumb-item active" aria-current="page">Supplier Details</li>
                </ol>
            </div>
        </div>



            <!-- supplier details content start-->
            <div class="row m-t-20">
                <div class="col-md-12">
                    <div class="card-box shadow py-5">
                        <div class="row">
                            <div class="col-md-8 offset-md-2">
                                <div class="card">
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item d-flex justify-content-start">
                                            <div class="w-50">Registration No:</div>
                                            <div class="w-50">{{$vendor_info->registration_no}}</div>
                                        </li>
{{--                                        <li class="list-group-item d-flex justify-content-start">--}}
{{--                                            <div class="w-50">Name:</div>--}}
{{--                                            <div class="w-50">{{$vendor_info->name}}</div>--}}
{{--                                        </li>--}}
                                        <li class="list-group-item d-flex justify-content-start">
                                            <div class="w-50">Company Name :</div>
                                            <div class="w-50">{{$vendor_info->company_name}}</div>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-start">
                                            <div class="w-50">VAT No :</div>
                                            <div class="w-50">{{$vendor_info->vat_no}}</div>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-start">
                                            <div class="w-50">Website :</div>
                                            <div class="w-50"><a href="{{$vendor_info->website}}" target="_blank">{{$vendor_info->website}}</a></div>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-start">
                                            <div class="w-50">Email :</div>
                                            <div class="w-50">{{$vendor_info->email}}</div>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-start">
                                            <div class="w-50">Phone :</div>
                                            <div class="w-50">{{$vendor_info->phone_no}}</div>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-start">
                                            <div class="w-50">Address :</div>
                                            <div class="w-50">{{$vendor_info->address}}</div>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-start">
                                            <div class="w-50">Country :</div>
                                            <div class="w-50">{{$vendor_info->country}}</div>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-start">
                                            <div class="w-50">State :</div>
                                            <div class="w-50">{{$vendor_info->state}}</div>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-start">
                                            <div class="w-50">Zip Code :</div>
                                            <div class="w-50">{{$vendor_info->zip_code}}</div>
                                        </li>
                                    </ul>
                                </div> <!--// End card-->
                            </div>
                        </div>
                    </div> <!--// End card-box -->
                </div> <!-- end col-md-12 -->
            </div> <!--// End supplier details content start-->


        </div> <!-- container -->
     </div> <!-- content -->
</div>  <!-- content page -->



@endsection
