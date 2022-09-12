
@extends('master')
@section('title')
    Setting | Invoice Setting | WMS360
@endsection
@section('content')
    <!-- Custombox -->
    <link href="{{asset('assets/plugins/custombox/css/custombox.css')}}" rel="stylesheet">
    <!-- Modal-Effect -->
    <script src="{{asset('assets/plugins/custombox/js/custombox.min.js')}}"></script>
    <script src="{{asset('assets/plugins/custombox/js/legacy.min.js')}}"></script>
    <div class="content-page">
        <!-- Start content -->
        <div class="content">
            <div class="container-fluid">


                <!----ON OFF SWITCH ARRAY KEY DECLARATION---->
                <input type="hidden" id="firstKey" value="onbuy">
                <input type="hidden" id="secondKey" value="onbuy_brand_list">
                <!----END ON OFF SWITCH ARRAY KEY DECLARATION---->


                <!--screen option-->
                <div class="row">
                    <div class="col-md-12">
                        <div class="card-box screen-option-content" style="display: none">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <div><p class="pagination"><b>Pagination</b></p></div>
                                    <ul class="column-display d-flex align-items-center">
                                        <li>Number of items per page</li>
                                        <li><input type="number" class="pagination-count" value="{{$pagination ?? 0}}"></li>
                                    </ul>
                                    <span class="pagination-mgs-show text-success"></span>
                                    <div class="submit">
                                        <input type="submit" class="btn submit-btn attr-cat-btn pagination-apply" value="Apply">
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <!--//screen option-->


                <div class="screen-option">
                    <div class="d-flex justify-content-start align-items-center">
                        <ol class="breadcrumb page-breadcrumb">
                            <li class="breadcrumb-item"> Setting </li>
                            <li class="breadcrumb-item active" aria-current="page"> Invoice Setting </li>
                        </ol>
                    </div>
                    <!-- <div class="screen-option-btn">
                        <button class="btn btn-link waves-effect waves-light" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                            Screen Options &nbsp; <i class="fa" aria-hidden="true"></i>
                        </button>
                        <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion"></div>
                    </div> -->
                </div>

                <div class="row m-t-20">
                    <div class="col-md-12">
                        <div class="card-box table-responsive shadow">
                            @if ($errors->any())
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif

                            @if (Session::has('success'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    {!! Session::get('success') !!}
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif

                            @if (Session::has('error'))
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    {!! Session::get('error') !!}
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif


                            <!-- <table id="table-sort-list" class="category-table w-100">
                                <thead>
                                <tr>
                                    <th>Invoice Setting</th>
                                </tr>
                                </thead>
                                <tbody id="table-body">
                                
                                        <tr>
                                            <td></td>
                                        </tr>
                                    
                                </tbody>
                            </table> -->
                            <!---------------------------ON OFF SWITCH BUTTON AREA------------------------>
                            <!--------------------------------------------------------------------------->

                        <form id="upload-logo-image" action="{{url('invoice-setting-form')}}" method="post" enctype="multipart/form-data">
                            @csrf     
                            <div class="row content-inner screen-option-responsive-content-inner">
                                <div class="col-md-12">
                                    <div class="d-flex align-items-center" style="margin-bottom: 20px;">
                                    <div class="ml-1" style="width:120px; font-weight:bold;"><p>SKU</p></div>
                                    <input type="hidden" name="sku_no" value="0"/>
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="sku_no" class="onoffswitch-checkbox" id="sku_no" value="1" @if(!isset($invoiceSetting['sku_no']) || $invoiceSetting['sku_no'] == 1) checked @endif>
                                            
                                            <label class="onoffswitch-label" for="sku_no">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                        
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="d-flex align-items-center" style="margin-bottom: 20px;">
                                    <div class="ml-1" style="width:120px; font-weight:bold;"><p>Variation ID</p></div>
                                    <input type="hidden" name="variation_id" value="0"/>
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="variation_id" class="onoffswitch-checkbox" id="variation_id" value="1" @if(!isset($invoiceSetting['variation_id']) || $invoiceSetting['variation_id'] == 1) checked @endif>
                                            <label class="onoffswitch-label" for="variation_id">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                        
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="d-flex align-items-center" style="margin-bottom: 20px;">
                                    <div class="ml-1" style="width:120px; font-weight:bold;"><p>EAN NO</p></div>
                                    <input type="hidden" name="ean_no" value="0"/>
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="ean_no" class="onoffswitch-checkbox" id="ean_no" value="1" @if(!isset($invoiceSetting['ean_no']) || $invoiceSetting['ean_no'] == 1) checked @endif>
                                            <label class="onoffswitch-label" for="ean_no">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                        
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="d-flex align-items-center" style="margin-bottom: 20px;">
                                    <div class="ml-1" style="width:120px; font-weight:bold;"><p>Attribute</p></div>
                                    <input type="hidden" name="attribute" value="0"/>
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="attribute" class="onoffswitch-checkbox" id="attribute" value="1" @if(!isset($invoiceSetting['attribute']) || $invoiceSetting['attribute'] == 1) checked @endif>
                                            <label class="onoffswitch-label" for="attribute">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                            <div class="ml-1" style="margin-bottom: 20px; width:120px; display:inline-block; font-weight:bold; width:10%;"><p>Default VAT</p></div>
                                <input style="width:70%; display:inline-block;" type="number" class="form-control" value="<?php if(!empty($invoiceSetting['default_vat'])){ echo $invoiceSetting['default_vat'];}else{ echo "20"; } ?>" name="default_vat" id="default_vat" placeholder="Add default VAT...">
                            </div>
                            <div class="col-12">
                            <div class="ml-1" style="margin-bottom: 20px; width:120px; display:inline-block; font-weight:bold; width:10%;"><p>Invoice Notice</p></div>
                                <input style="width:70%; display:inline-block;" type="text" class="form-control" name="invoice_notice" id="invoice_notice" value="{{$invoiceSetting['invoice_notice'] ?? ''}}" placeholder="Add some Invoice Message...">
                            </div>
                            <div class="col-12">
                            <div class="ml-1" style="margin-bottom: 20px; width:120px; display:inline-block; font-weight:bold; width:10%;"><p></p></div>
                            <button style="width:200px; margin-top:20px;" type="submit" class="btn btn-primary save-logo-url">Save Setting</button>
                            </div>

                        </form>    

                            <!---------------------------END ON OFF SWITCH BUTTON AREA------------------------>
                            <!--------------------------------------------------------------------------->


                            <!--table below pagination sec-->
                            
                            <!--End table below pagination sec-->

                        </div>
                    </div>
                </div> <!-- end row -->
            </div> <!-- container -->
        </div> <!-- content -->
    </div>

    <script>

        //Datatable row-wise searchable option
        


        //screen option toggle
        

    </script>


@endsection
