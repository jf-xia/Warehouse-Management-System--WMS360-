@extends('master')
@section('content')

    <!--responsive table plugin-->
    <link href="{{asset('assets/plugins/responsive-table/css/rwd-table.min.css')}}" rel="stylesheet" type="text/css" media="screen">

    <style>

        /*-- select all checkbox---- */

        /*.wrapper {*/
        /*    min-height: 100%;*/
        /*}*/
        /*.wrapper:before,*/
        /*.wrapper:after {*/
        /*    display: table;*/
        /*    content: " ";*/
        /*}*/
        /*.regular-checkbox {*/
        /*    display: none;*/
        /*}*/

        /*.regular-checkbox + label {*/
        /*    background-color: #fafafa;*/
        /*    border: 1px solid #cacece;*/
        /*    box-shadow: 0 1px 2px rgba(0,0,0,0.05), inset 0px -15px 10px -12px rgba(0,0,0,0.05);*/
        /*    padding: 9px;*/
        /*    border-radius: 3px;*/
        /*    display: inline-block;*/
        /*    position: relative;*/
        /*}*/

        /*.regular-checkbox + label:active, .regular-checkbox:checked + label:active {*/
        /*    box-shadow: 0 1px 2px rgba(0,0,0,0.05), inset 0px 1px 3px rgba(0,0,0,0.1);*/
        /*}*/

        /*.regular-checkbox:checked + label {*/
        /*    background-color: #e9ecee;*/
        /*    border: 1px solid #adb8c0;*/
        /*    box-shadow: 0 1px 2px rgba(0,0,0,0.05), inset 0px -15px 10px -12px rgba(0,0,0,0.05), inset 15px 10px -12px rgba(255,255,255,0.1);*/
        /*    color: #99a1a7;*/
        /*}*/

        /*.regular-checkbox:checked + label:after {*/
        /*    content: '\2714';*/
        /*    font-size: 14px;*/
        /*    position: absolute;*/
        /*    top: 0px;*/
        /*    left: 3px;*/
        /*    color: #99a1a7;*/
        /*}*/
        /*.big-checkbox + label {*/
        /*    padding: 18px;*/
        /*}*/
        /*.big-checkbox:checked + label:after {*/
        /*    font-size: 28px;*/
        /*    left: 6px;*/
        /*}*/

        /*-- select all checkbox---- */

    </style>



    <div class="content-page">
        <!-- Start content -->
        <div class="content">
            <div class="container-fluid">

                <!-- Page-Title -->
                <div class="row">
                    <div class="col-sm-12 text-center">
                        <div class="vendor-title">
                            <p>Vendor Product List</p>
                        </div>
                    </div>
                </div>

                <div class="row m-t-20">
                    <div class="col-12">
                        <div class="card-box">
                            @if($errors->any())
                                <div class="alert alert-danger">
                                    @foreach($errors->all() as $error)
                                        <li>{{$error}}</li>
                                    @endforeach
                                </div>
                            @endif
                            <form class="example m-b-10" action="{{url('indivisual-vendor-invoice-search')}}" method="post">
                                @csrf
                                <input type="text" placeholder="Search.." name="search">
                                <button type="submit"><i class="fa fa-search"></i></button>
                                <div class="button-group">
                                    <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-cog"></span> <span class="caret"></span></button>
                                    <ul class="dropdown-menu">
                                        <li><a href="#" class="small" data-value="option1" tabIndex="-1"><input type="checkbox" name="chek_value[]" value="invoice_number"/>&nbsp;Invoice No.</a></li>
                                    </ul>
                                </div>

                            </form>
                            <form action="" method="post">
                                @csrf
                                <div class="table-rep-plugin">
                                    <div class="table-responsive" data-pattern="priority-columns">

                                        <table id="tech-companies-1" class="table table-bordered  table-striped" style="border-collapse:collapse;">
                                            <thead>
                                            <tr>
                                                <th data-priority="1">Invoice No.</th>
                                                <th data-priority="1">Invoice Total Price</th>
                                                <th data-priority="3">Invoice Receive By</th>
                                                <th data-priority="3">Receive Data</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($single_invoice_info as $variation_product)
                                                <tr style="cursor: pointer" data-toggle="collapse" data-target="#demo{{$variation_product->id}}" class="accordion-toggle">
                                                    <td>{{$variation_product->invoice_number}}</td>
                                                    <td>{{$variation_product->invoice_total_price}}</td>
                                                    <td><a href="{{url('vendor-product-list/'.$variation_product->receiver_user_id)}}">{{$variation_product->user_info->name}}</a></td>
                                                    <td>{{date('d-m-Y', strtotime($variation_product->receive_date))}}</td>
                                                </tr>

                                                <tr>
                                                    <td colspan="5" class="hiddenRow">
                                                        <div class="accordian-body collapse" id="demo{{$variation_product->id}}">
                                                            <div class="row">
                                                                <div class="col-12">
                                                                    <div class="card p-2 m-t-5 m-b-5 m-l-5 m-r-5">
                                                                        <div style="border: 1px solid #ccc;">
                                                                            <div class="row m-t-10">
                                                                                <div class="col-3 text-center">
                                                                                    <h6> SKU </h6>
                                                                                    <hr width="60%">
                                                                                </div>
                                                                                <div class="col-3 text-center">
                                                                                    <h6>Quantity</h6>
                                                                                    <hr width="60%">
                                                                                </div>
                                                                                <div class="col-3 text-center">
                                                                                    <h6> Unit Price </h6>
                                                                                    <hr width="60%">
                                                                                </div>
                                                                                <div class="col-3 text-center">
                                                                                    <h6> Total Price </h6>
                                                                                    <hr width="60%">
                                                                                </div>
                                                                            </div>
                                                                            @foreach($variation_product->invoice_product_variation_info as $product_variation_info)
                                                                                <div class="row">
                                                                                    <div class="col-3 text-center">
                                                                                        <h7> {{$product_variation_info->sku}} </h7>
                                                                                    </div>
                                                                                    <div class="col-3 text-center">
                                                                                        <h7> {{$product_variation_info->pivot->quantity}} </h7>
                                                                                    </div>
                                                                                    <div class="col-3 text-center">
                                                                                        <h7> {{$product_variation_info->pivot->price}} </h7>
                                                                                    </div>
                                                                                    <div class="col-3 text-center">
                                                                                        <h7> {{$product_variation_info->pivot->total_price}} </h7>
                                                                                    </div>
                                                                                </div>
                                                                            @endforeach

                                                                        </div>
                                                                    </div> <!-- end card -->
                                                                </div> <!-- end col-12 -->
                                                            </div> <!-- end row -->
                                                        </div> <!-- end accordion body -->
                                                    </td> <!-- hide expand td-->
                                                </tr> <!-- hide expand row-->
                                            @endforeach
                                            </tbody>
                                        </table>

                                    </div>  <!--//table responsive priority column-->

                                </div> <!---// table-rep-plugin--->

                            </form>
                        </div> <!--// card box--->
                    </div> <!-- // col-12 -->
                </div> <!-- end row -->
            </div> <!-- container -->
        </div> <!-- content -->
    </div> <!-- content page -->

    <!-- responsive-table-->
    <script src="{{asset('assets/plugins/responsive-table/js/rwd-table.min.js')}}" type="text/javascript"></script>

@endsection




