
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
                            <p>Invoice Edit</p>
                        </div>
                    </div>
                </div>
                
                <div class="row m-t-20">
                    <div class="col-md-12">
                        <div class="card-box">

                            <form  class="vendor-form" action="{{route('invoice.update',$invoice_result->id)}}" method="post">
                                @csrf
                                @method('PUT')

                                <div class="form-group row">
                                    <div class="col-md-1"></div>
                                    <label for="invoice_no" class="col-md-2 col-form-label required">Invoice No</label>
                                    <div class="col-md-8">
                                        <input type="text" name="invoice_number" class="form-control" id="invoice_no" value="{{$invoice_result->invoice_number}}" placeholder="" required>
                                    </div>
                                    <div class="col-md-1"></div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-1"></div>
                                    <label for="vendor" class="col-md-2 col-form-label required">Vendor</label>
                                    <div class="col-md-8">
                                        <select name="vendor_id" class="form-control" required >
                                            <option value="{{$invoice_result->vendor_id}}">{{\App\Vendor::find($invoice_result->vendor_id)->name  }}</option>
{{--                                            @foreach($vendor_results as $vendor)--}}
{{--                                                @if(\App\Vendor::find($invoice_result->vendor_id)->name != $vendor->name)--}}
{{--                                                    <option value="{{$vendor->id}}">{{$vendor->name}}</option>--}}
{{--                                                @endif--}}
{{--                                            @endforeach--}}
                                        </select>
                                    </div>
                                    <div class="col-md-1"></div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-1"></div>
                                    <label for="date" class="col-md-2 col-form-label required">Date</label>
                                    <div class="col-md-8">
                                        <div class="input-group">
                                            <input type="text" class="form-control" placeholder="mm/dd/yyyy" value="{{$invoice_result->receive_date}}" id="datepicker-autoclose" required>
                                            <div class="input-group-append">
                                                <span class="input-group-text"><i class="md md-event-note"></i></span>
                                            </div>
                                        </div><!-- input-group -->
                                    </div>
                                    <div class="col-md-1"></div>
                                </div>

                                <div class="form-group row vendor-btn-top">
                                    <div class="col-md-12 text-center">
                                        <button class="vendor-btn" type="submit" class="btn btn-primary waves-effect waves-light">
                                            <b> Update </b>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <!-- card-box -->
                    </div>
                    <!-- end col -->
                </div>
                <!-- end row -->
            </div>
            <!-- container -->
        </div>
        <!-- content -->
    </div>
    <!-- content page-->

@endsection
