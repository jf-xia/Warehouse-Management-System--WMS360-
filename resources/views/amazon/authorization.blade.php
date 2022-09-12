
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
                            <p>Authorization</p>
                        </div>
                    </div>
                </div>

                <div class="row m-t-20">
                    <div class="col-md-12">
                        <div class="card-box shadow">
                            <a href="{{url('https://sellercentral.amazon.co.uk/apps/authorize/consent?application_id=amzn1.sp.solution.ba5841a2-7340-493b-8f63-40c14542f2ee&state=abc&version=beta')}}" class="btn btn-info" target="_blank">Authorize WMS</a>
                            <a href="{{url('https://sellercentral.amazon.co.uk/apps/authorize/consent?application_id=amzn1.sp.solution.badbc44c-58a7-49f6-a307-19c52412adbb&state=abc&version=beta')}}" class="btn btn-info" target="_blank">Authorize Combo WMS</a>
                            <a href="{{url('https://sellercentral.amazon.co.uk/apps/authorize/consent?application_id=amzn1.sp.solution.4e88a5e3-cb35-4293-9352-170e9504127b&state=abc&version=beta')}}" class="btn btn-info" target="_blank">Authorize Maf Combo WMS</a>
                            <a href="{{url('https://sellercentral.amazon.co.uk/apps/authorize/consent?application_id=amzn1.sp.solution.9e70c9f0-1e85-413e-b7ac-bf239a5d4e83&state=abc&version=beta')}}" class="btn btn-info" target="_blank">Authorize Sallu WMS</a>
                        </div>  <!-- card-box -->
                    </div> <!-- end col -->
                </div>
                <!-- end row -->
            </div> <!-- container -->
        </div> <!-- content -->

    </div>
@endsection
