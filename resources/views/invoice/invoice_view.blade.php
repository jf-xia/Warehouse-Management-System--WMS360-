@extends('master')

@section('title')
    Invoice History | WMS360
@endsection

@section('content')

    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>

    <!-- Custombox -->
    <link href="{{asset('assets/plugins/custombox/css/custombox.css')}}" rel="stylesheet">

    <!-- Modal-Effect -->
    <script src="{{asset('assets/plugins/custombox/js/custombox.min.js')}}"></script>
    <script src="{{asset('assets/plugins/custombox/js/legacy.min.js')}}"></script>



    <div class="content-page">
        <!-- Start content -->
        <div class="content">
            <div class="container-fluid">

                <div class="d-flex justify-content-between align-items-center">
                    <ol class="breadcrumb page-breadcrumb">
                        <li class="breadcrumb-item">Inventory</li>
                        <li class="breadcrumb-item active" aria-current="page">Invoice History</li>
                    </ol>
                </div>


                <div class="row m-t-20 invoice-view">
                    <div class="col-12">
                        <div class="card-box shadow table-responsive">

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

                            @if(Session::has('message'))
                                <div class="alert alert-danger">
                                    <button type="button" class="close" data-dismiss="alert">×</button>
                                    <strong>{!! Session::get('message') !!}</strong>
                                </div>
                            @endif


{{--                            <form class="example m-t-10 m-b-10" action="{{route('invoice-search.search')}}" method="post">--}}
{{--                                @csrf()--}}
{{--                                <div class="row">--}}
{{--                                    <div class="col-lg-2 col-md-2 col-sm-6">--}}
{{--                                        <input type="text" name="invoice_number" placeholder="Search invoice no ..." class="form-control s-invoice">--}}
{{--                                    </div>--}}

{{--                                    <div class="col-lg-2 col-md-2 col-sm-6">--}}
{{--                                        <input type="text" name="sku_or_id" placeholder="Search sku ..." class="form-control s-invoice">--}}
{{--                                    </div>--}}

{{--                                    <div class="col-lg-2 col-md-2 col-sm-6">--}}
{{--                                        <select id="vendor_id" class="form-control select2 f-size" name="vendor_id">--}}
{{--                                            <option value="">Search Supplier ...</option>--}}
{{--                                            @foreach($vendors as $vendor)--}}
{{--                                                <option value="{{$vendor->id}}">{{$vendor->company_name}}</option>--}}
{{--                                            @endforeach--}}
{{--                                        </select>--}}
{{--                                    </div>--}}

{{--                                    <div class="col-lg-1 col-md-1 col-sm-6 start-date">--}}
{{--                                         <div class="s-mt">Start Date</div>--}}
{{--                                    </div>--}}
{{--                                    <div class="col-lg-2 col-md-2 col-sm-6">--}}
{{--                                        <input type="date" name="start_date" class="form-control f-size" placeholder="Search start date...">--}}
{{--                                    </div>--}}


{{--                                    <div class="col-lg-1 col-md-1 col-sm-6 end-date">--}}
{{--                                        <div class="s-mt">End Date</div>--}}
{{--                                    </div>--}}
{{--                                    <div class="col-lg-2 col-md-2 col-sm-6">--}}
{{--                                        <input type="date" name="end_date" class="form-control f-size" placeholder="Search end date...">--}}
{{--                                    </div>--}}
{{--                                </div>--}}

{{--                                <div class="row pt-2">--}}
{{--                                    <div class="col-md-2 offset-md-5 s-btn">--}}
{{--                                        <button type="submit" class="btn btn-primary vendor-btn waves-effect waves-light"><i class="fa fa-search"></i></button>--}}
{{--                                    </div>--}}
{{--                                </div>--}}

{{--                            </form>--}}

                                <div class="m-b-20 m-t-10">
                                    <div class="product-inner">

                                        <div class="draft-search-form">
                                            <form class="d-flex" action="{{url('invoice/number/search')}}" method="post">
                                                @csrf
                                                <div class="p-text-area">
                                                    <input type="text" name="search_value" class="form-control" placeholder="Search Invoice..." required>
                                                    <input type="hidden" name="column_name" value="sku">
                                                </div>
                                                <div class="submit-btn">
                                                    <button class="search-btn waves-effect waves-light" type="submit">Search</button>
                                                </div>
                                            </form>
                                        </div>


                                        <!--Start Pagination section-->
                                        <div class="pagination-area">
                                            <form action="{{url('pagination-all')}}" method="post">
                                                @csrf
                                                <div class="datatable-pages d-flex align-items-center">
                                                    <span class="displaying-num">{{$invoice_result->total()}} items</span>
                                                    <span class="pagination-links d-flex">
                                                        @if($invoice_result->currentPage() > 1)
                                                        <a class="first-page btn {{$invoice_result->currentPage() > 1 ? '' : 'disable'}}" href="{{$invoice_results->first_page_url}}" data-toggle="tooltip" data-placement="top" title="First Page">
                                                            <span class="screen-reader-text d-none">First page</span>
                                                            <span aria-hidden="true">«</span>
                                                        </a>
                                                        <a class="prev-page btn {{$invoice_result->currentPage() > 1 ? '' : 'disable'}}" href="{{$invoice_results->prev_page_url}}" data-toggle="tooltip" data-placement="top" title="Previous Page">
                                                            <span class="screen-reader-text d-none">Previous page</span>
                                                            <span aria-hidden="true">‹</span>
                                                        </a>
                                                        @endif
                                                        <span class="paging-input d-flex align-items-center">
                                                            <label for="current-page-selector" class="screen-reader-text d-none">Current Page</label>
                                                            <input class="current-page" id="current-page-selector" type="text" name="paged" value="{{$invoice_results->current_page}}" size="3" aria-describedby="table-paging">
                                                            <span class="datatable-paging-text d-flex"> of <span class="total-pages">{{$invoice_results->last_page}}</span></span>
                                                            <input type="hidden" name="route_name" value="invoice">
                                                        </span>
                                                        @if($invoice_result->currentPage() !== $invoice_result->lastPage())
                                                        <a class="next-page btn" href="{{$invoice_results->next_page_url}}" data-toggle="tooltip" data-placement="top" title="Next Page">
                                                            <span class="screen-reader-text d-none">Next page</span>
                                                            <span aria-hidden="true">›</span>
                                                        </a>
                                                        <a class="last-page btn" href="{{$invoice_results->last_page_url}}" data-toggle="tooltip" data-placement="top" title="Last Page">
                                                            <span class="screen-reader-text d-none">Last page</span>
                                                            <span aria-hidden="true">»</span>
                                                        </a>
                                                        @endif
                                                    </span>
                                                </div>
                                            </form>
                                        </div>
                                        <!--End Pagination section-->
                                    </div>
                                </div>


                                <table class="product-draft-table w-100" style="border-collapse:collapse;">
                                    <thead>
                                    <tr>
                                        <th>
                                            <div class="d-flex">
                                                <div class="btn-group">
                                                    <form action="{{url('invoice/history/column/search')}}" method="post">
                                                        @csrf
                                                        <a type="button" class="dropdown-toggle filter-btn" data-toggle="dropdown">
                                                            <i class="fa" aria-hidden="true"></i>
                                                        </a>
                                                        <div class="dropdown-menu filter-content shadow" role="menu">
                                                            <p>Filter Value</p>
                                                            <input type="text" class="form-control input-text" name="search_value">
                                                            <div class="checkbox checkbox-custom checkbox m-t-10 m-b-10">
                                                                <input id="opt-out1" type="checkbox" name="opt_out" value="1"><label for="opt-out1">Opt Out</label>
                                                            </div>
                                                            <input type="hidden" name="column_name" value="invoice_number">
                                                            <button type="submit" class="btn btn-primary filter-apply-btn float-right">Apply <i class="fa fa-arrow-circle-right ml-1"></i></button>
                                                        </div>
                                                    </form>
                                                </div>
                                                <div>Invoice No</div>
                                            </div>
                                        </th>
                                        <th>
                                            <div class="d-flex">
                                                <div class="btn-group">
                                                    <form action="{{url('invoice/history/column/search')}}" method="post">
                                                        @csrf
                                                        <a type="button" class="dropdown-toggle filter-btn" data-toggle="dropdown">
                                                            <i class="fa" aria-hidden="true"></i>
                                                        </a>
                                                        @php
                                                           $all_supplier_name = \App\Vendor::orderBy('company_name', 'ASC')->get();
                                                        @endphp
                                                        <div class="dropdown-menu filter-content shadow" role="menu">
                                                            <p>Filter Value</p>
                                                            <select class="form-control b-r-0" name="search_value">
                                                                @if(isset($all_supplier_name))
                                                                    @if($all_supplier_name->count() == 1)
                                                                        @foreach($all_supplier_name as $supplier_name)
                                                                            <option value="{{$supplier_name->company_name}}">{{$supplier_name->company_name}}</option>
                                                                        @endforeach
                                                                    @else
                                                                        <option hidden>Select Supplier</option>
                                                                        @foreach($all_supplier_name as $supplier_name)
                                                                            <option value="{{$supplier_name->company_name}}">{{$supplier_name->company_name}}</option>
                                                                        @endforeach
                                                                    @endif
                                                                @endif
                                                            </select>
                                                            <div class="checkbox checkbox-custom checkbox m-t-10 m-b-10">
                                                                <input id="opt-out2" type="checkbox" name="opt_out" value="1"><label for="opt-out2">Opt Out</label>
                                                            </div>
                                                            <input type="hidden" name="column_name" value="company_name">
                                                            <button type="submit" class="btn btn-primary filter-apply-btn float-right">Apply <i class="fa fa-arrow-circle-right ml-1"></i></button>
                                                        </div>
                                                    </form>
                                                </div>
                                                <div>Supplier</div>
                                            </div>
                                        </th>
                                        <th>
                                            <div class="d-flex">
                                                <div class="btn-group">
                                                    <form action="{{url('invoice/history/column/search')}}" method="post">
                                                        @csrf
                                                        <a type="button" class="dropdown-toggle filter-btn" data-toggle="dropdown">
                                                            <i class="fa" aria-hidden="true"></i>
                                                        </a>
                                                        <div class="dropdown-menu filter-content shadow" role="menu">
                                                            <p>Filter Value</p>
                                                            <input type="text" class="form-control input-text" name="search_value" placeholder="Y-M-D or D-M-Y">
                                                            <div class="checkbox checkbox-custom checkbox m-t-10 m-b-10">
                                                                <input id="opt-out3" type="checkbox" name="opt_out" value="1"><label for="opt-out3">Opt Out</label>
                                                            </div>
                                                            <input type="hidden" name="column_name" value="receive_date">
                                                            <button type="submit" class="btn btn-primary filter-apply-btn float-right">Apply <i class="fa fa-arrow-circle-right ml-1"></i></button>
                                                        </div>
                                                    </form>
                                                </div>
                                                <div>Last Receive Date</div>
                                            </div>
                                        </th>
                                        <th>Invoice Type</th>
                                        {{--                                            <th>Total price</th>--}}
                                        <th style="width: 10%">Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($invoice_results->data as $key => $value)
                                        @php
                                            if(!empty($value->receive_date)){
                                            $receive_date = date("d-m-Y H:m:s", strtotime($value->receive_date));
                                            }else{
                                            $receive_date = '';
                                            }
                                        @endphp
                                        @if(!empty($value->invoice_product_variations))
                                            <tr>
                                                <td style="cursor: pointer">
                                                    <span id="master_opc_{{$key}}">
                                                         <div class="id_tooltip_container d-flex justify-content-start align-items-center">
                                                            <span title="Click to Copy" onclick="textCopiedID(this);" class="id_copy_button">{{$value->invoice_number}}</span>
                                                            <span class="wms__id__tooltip__message" id="wms__id__tooltip__message">Copied!</span>
                                                         </div>
                                                    </span>
                                                </td>
                                                <td style="cursor: pointer" data-toggle="collapse" data-target="#demo{{$key}}" class="accordion-toggle">{{\App\Vendor::find($value->vendor_id)->company_name }}</td>
                                                <td style="cursor: pointer" data-toggle="collapse" data-target="#demo{{$key}}" class="accordion-toggle"><span style="margin-top: 4px;">{{$receive_date}}</span></td>
                                                <td>
                                                    @if(!isset($value->return_order_id))
                                                        <a href="javascript:void(0);" class="label label-table label-success">New Product invoice</a>
                                                    @else

                                                        <a class="label label-table label-warning text-center" style="margin-top: 4px;" href="#" data-toggle="modal" data-target="#myNewProductInvoice">Return Product details</a>

                                                        <!-- The Modal -->
                                                        <div class="modal fade" id="myNewProductInvoice">
                                                            <div class="modal-dialog modal-lg">
                                                                <div class="modal-content">

                                                                    <!-- Modal Header -->
                                                                    <div class="modal-header">
                                                                        <h4 class="modal-title">Return Order details</h4>
                                                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                                    </div>

                                                                    <!-- Modal body -->
                                                                    <div class="modal-body">
                                                                        <fieldset>
                                                                            <legend>Return Reason:</legend>
                                                                            <div class="panel panel-primary">
                                                                                <div class="panel-body">
                                                                                    <p class="text-justify">
                                                                                        {{$value->return_order_info->return_reason ? $value->return_order_info->return_reason : ''}}
                                                                                    </p>
                                                                                </div>
                                                                            </div>
                                                                        </fieldset>


                                                                        <div class="row m-t-20">
                                                                            <div class="col-md-6">
                                                                                <div class="card">
                                                                                    <h6> <span style="margin-left: 10px;"> Cost: {{$value->return_order_info->return_cost ? $value->return_order_info->return_cost : ''}}</span></h6>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-6"></div>
                                                                        </div>
                                                                        <div class="row m-t-20">
                                                                            <div class="col-md-6">
                                                                                <div class="card">
                                                                                    <h6> <span style="margin-left: 10px;"> Order No: {{\App\Order::find($value->return_order_info->order_id)->order_number}}</span></h6>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-6"></div>
                                                                        </div>
                                                                    </div>

                                                                    <!-- Modal footer -->
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                                                    </div>

                                                                </div>
                                                            </div>
                                                        </div> <!--// end The Modal -->

                                                    @endif
                                                </td>
                                                {{--                                            <td>{{$value->invoice_total_price}}</td>--}}
                                                <td class="actions"  style="width: 10%">
                                                    <div class="d-flex justify-content-start align-items-center">
                                                        <div>
                                                            <a class="btn-size edit-btn mr-2" href="#editInvoiceView{{$value->id}}" data-animation="slit" data-plugin="custommodal" data-overlaySpeed="100" data-overlayColor="#36404a"  data-placement="top" title="Edit"><i class="fa fa-edit" aria-hidden="true"></i></a>
{{--                                                            <a class="btn-size edit-btn mr-2" href="{{route('invoice.edit',$value->id)}}" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-edit" aria-hidden="true"></i></a>--}}
                                                        </div>
                                                        <div>
                                                            <form action="{{route('invoice.destroy',$value->id)}}" method="post">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button onclick="return check_delete('invoice')" type="submit" class="btn-size del-pub-n del-pub delete-btn" style="cursor: pointer" data-toggle="tooltip" data-placement="top" title="Delete"><i class="fa fa-trash" aria-hidden="true"></i></button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>


                                            <!-- Edit Invoice View Modal -->
                                            <div id="editInvoiceView{{$value->id}}" class="modal-demo">
                                                <button type="button" class="close" onclick="Custombox.close();">
                                                    <span>&times;</span><span class="sr-only">Close</span>
                                                </button>
                                                <h4 class="custom-modal-title">Edit Invoice View</h4>
                                                <form role="form" class="vendor-form mobile-responsive" action="{{url('invoice/'.$value->id)}}" method="post">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="form-group row">
                                                        <div class="col-md-1"></div>
                                                        <label for="invoice_no" class="col-md-2 col-form-label required">Invoice No</label>
                                                        <div class="col-md-8">
                                                            <input type="text" name="invoice_number" class="form-control" id="invoice_no" value="{{$value->invoice_number}}" placeholder="" required>
                                                        </div>
                                                        <div class="col-md-1"></div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <div class="col-md-1"></div>
                                                        <label for="vendor" class="col-md-2 col-form-label required">Supplier</label>
                                                        <div class="col-md-8">
                                                            <select name="vendor_id" class="form-control" required >
                                                                <option value="{{$value->vendor_id}}">{{\App\Vendor::find($value->vendor_id)->name  }}</option>
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
                                                                <input type="text" class="form-control" placeholder="mm/dd/yyyy" value="{{$value->receive_date}}" id="datepicker-autoclose" required>
                                                                <div class="input-group-append">
                                                                    <span class="input-group-text"><i class="md md-event-note"></i></span>
                                                                </div>
                                                            </div><!-- input-group -->
                                                        </div>
                                                        <div class="col-md-1"></div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <div class="col-md-12 text-center  mb-5 mt-3">
                                                            <button type="submit" class="btn btn-primary vendor-btn waves-effect waves-light">
                                                                <b>Update</b>
                                                            </button>
                                                        </div>
                                                    </div>

                                                </form>
                                            </div>
                                            <!--End Edit Invoice View Modal -->



                                            <tr>
                                                <td colspan="8" class="hiddenRow" style="padding: 0">
                                                    <div class="accordian-body collapse" id="demo{{$key}}">
                                                        <div class="row">
                                                            <div class="col-12">
                                                                <div class="card p-2 m-t-5 m-b-5 m-l-5 m-r-5">
                                                                    <div class="row m-t-10">
                                                                        <div class="col-3 text-center">
                                                                            <h6>SKU </h6>
                                                                            <hr width="60%">
                                                                        </div>
                                                                        <div class="col-3 text-center">
                                                                            <h6>Receive Quantity</h6>
                                                                            <hr width="60%">
                                                                        </div>
                                                                        <div class="col-2 text-center">
                                                                            <h6> Unit Price </h6>
                                                                            <hr width="60%">
                                                                        </div>
                                                                        <!-- <div class="col-2 text-center">
                                                                            <h6> Product Type </h6>
                                                                            <hr width="60%">
                                                                        </div> -->
                                                                        @if($shelfUse == 1)
                                                                            <div class="col-2 text-center">
                                                                                <h6> Shelver </h6>
                                                                                <hr width="60%">
                                                                            </div>
                                                                        @endif
                                                                        <div class="col-2 text-center">
                                                                            <h6> Total Price</h6>
                                                                            <hr width="100%">
                                                                        </div>
                                                                        {{--                                                                    <div class="col-2 text-center">--}}
                                                                        {{--                                                                        <h6> Action </h6>--}}
                                                                        {{--                                                                        <hr width="60%">--}}
                                                                        {{--                                                                    </div>--}}
                                                                    </div>
                                                                    <?php
                                                                    $total_price = 0;
                                                                    $total_quantity = 0;
                                                                    ?>



                                                                    @foreach($value->invoice_product_variations as $product_variation)

                                                                        @php
                                                                            $find_sku = \App\ProductVariation::find($product_variation->product_variation_id)->sku ?? '';
                                                                            $search_value = $search_value ?? '';
                                                                        @endphp

                                                                        <div class="row p-1" @if($find_sku == $search_value) style="background: #F7F635" @endif>
                                                                            <div class="col-3 text-center">
                                                                                <h7> @if(isset(\App\ProductVariation::find($product_variation->product_variation_id)->sku)) {{\App\ProductVariation::find($product_variation->product_variation_id)->sku }} @endif</h7>
                                                                            </div>
                                                                            <div class="col-3 text-center">
                                                                                <h7> {{$product_variation->quantity}} </h7>
                                                                            </div>
                                                                            <div class="col-2 text-center">
                                                                                <h7> {{$product_variation->price}} </h7>
                                                                            </div>
                                                                            <!-- <div class="col-2 text-center">
                                                                                <h7> {{($product_variation->product_type != 0) ? ($product_variation->condition->condition_name ?? '') : "Defected"}}</h7>
                                                                            </div> -->
                                                                            @if($shelfUse == 1)
                                                                                <div class="col-2 text-center">
                                                                                    <h7> @if(isset(\App\User::find($product_variation->shelver_user_id)->name)) {{\App\User::find($product_variation->shelver_user_id)->name }}
                                                                                        @endif </h7>
                                                                                </div>
                                                                            @endif
                                                                            <div class="col-2 text-center">
                                                                                <h7>{{$product_variation->total_price}}</h7>
                                                                            </div>
                                                                            {{--                                                                    <div class="col-2 text-center form_action m-b-10">--}}
                                                                            {{--                                                                        <a href="" ><button class="vendor_btn_edit btn-primary font-8">Edit</button></a>&nbsp;--}}
                                                                            {{--                                                                        <form action="" method="post">--}}
                                                                            {{--                                                                           <a href="" ><button class="vendor_btn_edit btn-danger font-8">Delete</button></a>&nbsp;--}}
                                                                            {{--                                                                        </form>--}}
                                                                            {{--                                                                    </div>--}}
                                                                            @php
                                                                                $total_price +=  $product_variation->total_price ;
                                                                                $total_quantity +=  $product_variation->quantity ;
                                                                            @endphp
                                                                        </div>
                                                                    @endforeach



                                                                    <div class="row">
                                                                        <div class="col-3"></div>
                                                                        <div class="col-3">
                                                                            <hr class="m-t-0">
                                                                            <p style="margin-top: -10px;" class="text-center">{{$total_quantity}}</p>
                                                                        </div>
                                                                        <div class="@if($shelfUse == 1) col-4 @else col-2 @endif"></div>
                                                                        <div class="col-2">
                                                                            <hr class="m-t-0">
                                                                            <p style="margin-top: -10px;" class="text-center">{{$total_price}}</p>
                                                                        </div>
                                                                    </div>

                                                                </div> <!-- end card -->
                                                            </div> <!-- end col-12 -->
                                                        </div> <!-- end row -->
                                                    </div> <!-- end accordion body -->
                                                </td> <!-- hide expand td-->
                                            </tr> <!-- hide expand row-->
                                        @endif
                                    @endforeach
                                    </tbody>
                                </table>


                                <!--table below pagination sec-->
                                <div class="row table-foo-sec">
                                    <div class="col-md-6 d-flex justify-content-md-start align-items-center"> </div>
                                    <div class="col-md-6">
                                        <div class="d-flex justify-content-md-end align-items-center py-2">
                                            <div class="pagination-area">
                                                <div class="datatable-pages d-flex align-items-center">
                                                    <span class="displaying-num">{{$invoice_result->total()}} items</span>
                                                    <span class="pagination-links d-flex">
                                                    @if($invoice_result->currentPage() > 1)
                                                    <a class="first-page btn {{$invoice_result->currentPage() > 1 ? '' : 'disable'}}" href="{{$invoice_results->first_page_url}}" data-toggle="tooltip" data-placement="top" title="First Page">
                                                        <span class="screen-reader-text d-none">First page</span>
                                                        <span aria-hidden="true">«</span>
                                                    </a>
                                                    <a class="prev-page btn {{$invoice_result->currentPage() > 1 ? '' : 'disable'}}" href="{{$invoice_results->prev_page_url}}" data-toggle="tooltip" data-placement="top" title="Previous Page">
                                                        <span class="screen-reader-text d-none">Previous page</span>
                                                        <span aria-hidden="true">‹</span>
                                                    </a>
                                                    @endif
                                                    <span class="screen-reader-text" style="display: none;">Current Page</span>
                                                    <span class="paging-input d-flex align-items-center">
                                                        <span class="datatable-paging-text d-flex pl-1"> {{$invoice_results->current_page}} of <span class="total-pages"> {{$invoice_results->last_page}} </span></span>
                                                    </span>
                                                    @if($invoice_result->currentPage() !== $invoice_result->lastPage())
                                                    <a class="next-page btn" href="{{$invoice_results->next_page_url}}" data-toggle="tooltip" data-placement="top" title="Next Page">
                                                        <span class="screen-reader-text d-none">Next page</span>
                                                        <span aria-hidden="true">›</span>
                                                    </a>
                                                    <a class="last-page btn" href="{{$invoice_results->last_page_url}}" data-toggle="tooltip" data-placement="top" title="Last Page">
                                                        <span class="screen-reader-text d-none">Last page</span>
                                                        <span aria-hidden="true">»</span>
                                                    </a>
                                                    @endif
                                                </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--End table below pagination sec-->


                        </div>  <!--// card box--->
                    </div>  <!-- // col-md-12 -->
                </div>  <!-- end row -->

            </div> <!-- container -->
        </div> <!-- content -->
    </div> <!-- content page -->



    <script>

        // Select 2 dropdown option
        $('.select2').select2();


        //bootstrap dropdown with checkboxes
        var options = [];

        $( '.dropdown-menu a' ).on( 'click', function( event ) {

            var $target = $( event.currentTarget ),
                val = $target.attr( 'data-value' ),
                $inp = $target.find( 'input' ),
                idx;

            if ( ( idx = options.indexOf( val ) ) > -1 ) {
                options.splice( idx, 1 );
                setTimeout( function() { $inp.prop( 'checked', false ) }, 0);
            } else {
                options.push( val );
                setTimeout( function() { $inp.prop( 'checked', true ) }, 0);
            }

            $( event.target ).blur();

            console.log( options );
            return false;
        });

        //expand and collapse row datatable
        $('.accordian-body').on('show.bs.collapse', function () {
            $(this).closest("table")
                .find(".collapse.in")
                .not(this)
                .collapse('toggle')
        })

    </script>

@endsection




