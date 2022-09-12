
@extends('master')
@section('content')
    <link rel="stylesheet" href="{{asset('assets/css/loader.css')}}">
    <script type="text/javascript"
            src="https://www.viralpatel.net/demo/jquery/jquery.shorten.1.0.js"></script>

    <div class="content-page">
        <!-- Start content -->
        <div class="content">
            <div class="container-fluid">



                <!--screen option-->
                <div class="row">
                    <div class="col-md-12">
                        <div class="card-box screen-option-content product-screen-option-content" style="display: none">

                            <div class="mb-2"><p class="columns"><b>Columns</b></p></div>

                            <div class="d-flex justify-content-md-between mb-2">
                                <div class="d-flex align-items-center">
                                    <div class="column-display d-flex justify-content-lg-left sm-view">
                                        <div class="checkbox checkbox-custom checkbox-circle">
                                            <input id="display-all" type="checkbox" name="display-all"><label for="display-all">Display All</label>
                                        </div>
                                        <div class="checkbox checkbox-custom checkbox-circle">
                                            <input id="image" type="checkbox" name="image" checked><label for="image">Image</label>
                                        </div>
                                        <div class="checkbox checkbox-custom checkbox-circle">
                                            <input id="id" type="checkbox" name="id" checked><label for="id">ID</label>
                                        </div>
                                        <div class="checkbox checkbox-custom checkbox-circle">
                                            <input id="sku" type="checkbox" name="sku" checked><label for="sku">SKU</label>
                                        </div>
                                        <div class="checkbox checkbox-custom checkbox-circle">
                                            <input id="variation" type="checkbox" name="variation" checked><label for="variation">Variation</label>
                                        </div>
                                        <div class="checkbox checkbox-custom checkbox-circle">
                                            <input id="ean" type="checkbox" name="ean"><label for="ean">EAN</label>
                                        </div>
                                        <div class="checkbox checkbox-custom checkbox-circle">
                                            <input id="available-qty" type="checkbox" name="available-qty"><label for="available-qty">Available Qty</label>
                                        </div>
                                        <div class="checkbox checkbox-custom checkbox-circle">
                                            <input id="shelf-qty" type="checkbox" name="shelf-qty"><label for="shelf-qty">Shelf Qty</label>
                                        </div>
                                        <div class="checkbox checkbox-custom checkbox-circle">
                                            <input id="low-qty" type="checkbox" name="low-qty"><label for="low-qty">Low Qty</label>
                                        </div>
                                        <div class="checkbox checkbox-custom checkbox-circle">
                                            <input id="catalogue" type="checkbox" name="catalogue" checked><label for="catalogue">Catalogue</label>
                                        </div>
                                        <div class="checkbox checkbox-custom checkbox-circle">
                                            <input id="actions" type="checkbox" name="actions" checked><label for="actions">Actions</label>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div><p class="pagination"><b>Pagination</b></p></div>
                            <div class="pb-1">
                                <ul class="column-display d-flex justify-content-lg-left align-items-center">
                                    <li>Number of items per page</li>
                                    <li><input type="number" class="pagination-count"></li>
                                </ul>
                            </div>

                            <div class="submit">
                                <input type="submit" class="btn submit-btn" value="Apply">
                            </div>

                        </div>
                    </div>
                </div>
                <!--//screen option-->



                <div class="screen-option">
                    <div class="d-flex justify-content-start align-items-center">
                        <ol class="breadcrumb page-breadcrumb">
                            <li class="breadcrumb-item">Product</li>
                            <li class="breadcrumb-item active" aria-current="page">Product List</li>
                        </ol>
                    </div>
                    <div class="screen-option-btn">
                        <button class="btn btn-link waves-effect waves-light" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                            Screen Options &nbsp; <i class="fa" aria-hidden="true"></i>
                        </button>
                        <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion"></div>
                    </div>
                </div>




                <!-- Page-Title -->
                {{--                <div class="row">--}}
                {{--                    <div class="col-md-12">--}}
                {{--                        <div class="vendor-title draft-title d-flex align-items-center justify-content-between">--}}
                {{--                            <div>--}}
                {{--                                <p class="title">Product List <span class="font-weight-bold" style="color: #81c868;">({{$total_variation}})</span></p>--}}
                {{--                            </div>--}}

                {{--                            <div>--}}
                {{--                                <ol class="breadcrumb">--}}
                {{--                                    <li class="breadcrumb-item"><a href="#"><i class="ti-home" aria-hidden="true"></i>Home</a></li>--}}
                {{--                                    <li class="breadcrumb-item"><a href="#">Product</a></li>--}}
                {{--                                    <li class="breadcrumb-item active" aria-current="page">Product List</li>--}}
                {{--                                </ol>--}}
                {{--                            </div>--}}
                {{--                        </div>--}}
                {{--                    </div>--}}
                {{--                </div>--}}


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
                <div class="card-box m-t-20 product-content shadow product-card">
                    <div class="row">
                        <div class="col-md-12">

                            <form class="example" action="javascript:void(0)">
                                <div class="m-b-20 m-t-10">

                                    <div class="product-inner">
                                        <div class="p-text-area">
                                            <input type="text" name="sku" id="sku" class="form-control product--list" placeholder="Search by ID, SKU or EAN....">
                                        </div>
                                        <div class="submit-btn">
                                            <button class="search-btn" type="submit" id="" onclick="search_variation();"><i class="fa fa-search"></i></button>
                                        </div>
                                        <div class="product-list-empty"></div>
                                        <div class="pagination-area">
                                            <div class="datatable-pages d-flex align-items-center">
                                                <span class="displaying-num"> {{$total_variation}} items</span>
                                                <span class="pagination-links d-flex">
                                                    <a class="first-page btn" href="#" data-toggle="tooltip" data-placement="top" title="First Page">
                                                        <span class="screen-reader-text d-none">First page</span>
                                                        <span aria-hidden="true">«</span>
                                                    </a>
                                                    <a class="prev-page btn" href="#" data-toggle="tooltip" data-placement="top" title="Previous Page">
                                                        <span class="screen-reader-text d-none">Previous page</span>
                                                        <span aria-hidden="true">‹</span>
                                                    </a>
                                                    <span class="paging-input d-flex align-items-center">
                                                        <label for="current-page-selector" class="screen-reader-text d-none">Current Page</label>
                                                        <input class="current-page" id="current-page-selector" type="text" name="paged" value="1" size="3" aria-describedby="table-paging">
                                                        <span class="datatable-paging-text d-flex"> of <span class="total-pages">3</span></span>
                                                    </span>
                                                    <a class="next-page btn" href="#" data-toggle="tooltip" data-placement="top" title="Next Page">
                                                        <span class="screen-reader-text d-none">Next page</span>
                                                        <span aria-hidden="true">›</span>
                                                    </a>
                                                    <a class="last-page btn" href="#" data-toggle="tooltip" data-placement="top" title="Last Page">
                                                        <span class="screen-reader-text d-none">Last page</span>
                                                        <span aria-hidden="true">»</span>
                                                    </a>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>


                            {{--                                <div class="input-group p-text-area">--}}
                            {{--                                    <input type="text" name="sku" id="sku" class="form-control" placeholder="Search by ID, SKU or EAN...." aria-label="Search by ID, SKU or EAN...." aria-describedby="basic-addon2">--}}
                            {{--                                    <div class="input-group-append">--}}
                            {{--                                        <span class="input-group-text" id="basic-addon2">@example.com</span>--}}
                            {{--                                    </div>--}}
                            {{--                                </div>--}}


                            {{--                                <div class="row position">--}}
                            {{--                                    <div class="col-md-9">--}}
                            {{--                                        {{$all_product_variation->links()}}--}}
                            {{--                                    </div>--}}
                            {{--                                    <div class="col-md-3">--}}
                            {{--                                        <div class="total-d-o font-bold" style="color: #81c868; padding-top: 25px">--}}
                            {{--                                            You are seeing : {{$variation_range->from}}-{{$variation_range->to}}--}}
                            {{--                                        </div>--}}
                            {{--                                    </div>--}}
                            {{--                                </div>--}}

                            <div id="Load" class="load" style="display: none;">
                                <div class="load__container">
                                    <div class="load__animation"></div>
                                    <div class="load__mask"></div>
                                    <span class="load__title">Content is loading...</span>
                                </div>
                            </div>

                            <div class="table-responsive">
                                <table id="table-sort-list" class="variation_search_result product-table">
                                    <thead>
                                    <tr>
                                        <th class="id" style="width: 7%; text-align: center !important;">ID</th>
                                        <th class="image">Image</th>
                                        <th class="sku" style="text-align: center !important;">SKU</th>
                                        <th class="variation">Variation</th>
                                        <th class="ean">EAN</th>
                                        <th class="sold">Sold</th>
                                        <th class="available-qty">Available Qty</th>
                                        <th class="shelf-qty">Shelf Qty</th>
                                        <th class="low-qty">Low Qty</th>
                                        <th class="catalogue">Catalogue</th>
                                        <th class="actions">Actions</th>

                                        {{--                                        <th class="header-cell" onclick="sortTable(0)">ID</th>--}}
                                        {{--                                        <th class="header-cell" onclick="sortTable(0)">Image</th>--}}
                                        {{--                                        <th class="header-cell" onclick="sortTable(0)">SKU</th>--}}
                                        {{--                                        <th class="header-cell" onclick="sortTable(0)">Variation</th>--}}
                                        {{--                                        <th class="header-cell" onclick="sortTable(0)">EAN</th>--}}
                                        {{--                                        <th class="header-cell" onclick="sortTable(0)">Sold</th>--}}
                                        {{--                                        <th class="header-cell" onclick="sortTable(0)">Available Qty</th>--}}
                                        {{--                                        <th class="header-cell" onclick="sortTable(0)">Shelf Qty</th>--}}
                                        {{--                                        <th class="header-cell" onclick="sortTable(0)">Low Qty</th>--}}
                                        {{--                                        <th class="header-cell" onclick="sortTable(0)">Catalogue</th>--}}
                                        {{--                                        <th class="header-cell" onclick="sortTable(0)">Actions</th>--}}

                                    </tr>
                                    </thead>
                                    <tbody id="table-body">
                                    @foreach($all_product_variation as $product_variation)
                                        @php
                                            $total_sold = 0;
                                             foreach ($product_variation->master_variation->order_products as $product){
                                                 $total_sold += $product->sold;
                                             }
                                                $data = 0;
                                             $master_image = json_decode($product_variation->master_catalogue->images);
                                        @endphp
                                        @foreach($product_variation->master_variation->shelf_quantity as $total)
                                            @php
                                                $data += $total->pivot->quantity;
                                            @endphp
                                        @endforeach
                                        @if($data != 0)
                                            <tr>
                                                {{--                                            <td>{!! str_limit(strip_tags($product_variation->description),$limit = 10,$end='...') !!}</td>--}}
                                                <td class="id" style="width: 7%; text-align: center !important;">{{$product_variation->id}}</td>
                                                @if($product_variation->image != null)
                                                    <td class="image"><a href="{{$product_variation->image}}" target="_blank"><img class="product-img" src="{{$product_variation->image}}" alt="Responsive image"></a></td>
                                                @elseif(isset($master_image[0]->image_url))
                                                    <td class="image"><a href="{{$master_image[0]->image_url}}" target="_blank"><img class="product-img" src="{{$master_image[0]->image_url}}" alt="Responsive image"></a></td>
                                                @else
                                                    <td class="image"><img class="product-img" src="{{asset('assets/images/users/no_image.jpg')}}" alt="Responsive image"></td>
                                                @endif
                                                <td class="sku" style="text-align: center !important;">{{$product_variation->sku}}</td>
                                                {{--                                            @if($product_variation->barcode)--}}
                                                {{--                                                <td><a href="{{asset('barcode/'.$product_variation->barcode)}}" download="" title="click to dowmload"><img src="{{asset('barcode/'.$product_variation->barcode)}}" alt="sku barcode"></a>--}}
                                                {{--                                                    <span style="position: absolute;"><a href="{{url('print-barcode/'.$product_variation->id)}}" target="_blank"><i class="fa fa-print"></i></a></span>--}}
                                                {{--                                                </td>--}}
                                                {{--                                            @else--}}
                                                {{--                                                <td><a href="{{url('print-barcode/'.$product_variation->id)}}" class="btn btn-success btn-sm" title="Click to print" target="_blank">Print Barcode</a></td>--}}
                                                {{--                                            @endif--}}
                                                <td class="variation">
                                                    @isset($product_variation->attribute)
                                                        @foreach(\Opis\Closure\unserialize($product_variation->attribute) as $attribute)
                                                            <div class="d-flex">
                                                                <div class="align-items-center"><b style="color: #7e57c2">{{$attribute['attribute_name']}}</b> <i class="fas fa-long-arrow-alt-right" aria-hidden="true"></i> {{$attribute['terms_name']}} &nbsp; &nbsp;</div>
                                                            </div>
                                                        @endforeach
                                                    @endisset
                                                </td>
                                                <td class="ean">{{$product_variation->ean_no}}</td>
                                                <td>{{$total_sold ?? 0}}</td>
                                                <td class="available-qty">{{$product_variation->actual_quantity}}</td>

                                                @if($product_variation->notification_status == 1 && $data < $product_variation->low_quantity)
                                                    <td class="shelf-qty">{{$data}}<br><span class="label label-table label-danger">Low Quantity {{$product_variation->low_quantity}}</span></td>
                                                @else
                                                    <td class="shelf-qty">{{$data}}</td>
                                                @endif
                                                <td class="low-qty">{{$product_variation->low_quantity}}</td>
                                                <td class="catalogue"><a class="catalogue-name" href="{{url('woocommerce/'.$product_variation->master_catalogue->status.'/catalogue/'.$product_variation->master_catalogue->id.'/show')}}" title="View Details" target="_blank">  {{$product_variation->master_catalogue->name}}  </a> </td>
                                                <td class="actions">
                                                    <div class="d-flex justify-content-start">
                                                        <div class="align-items-center mr-2"><a class="btn-size btn-primary" href="{{url('woocommerce/variation/'.$product_variation->id.'/edit')}}" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-edit" aria-hidden="true"></i></a></div>
                                                        <div class="align-items-center mr-2"><a class="btn-size btn-success" href="{{url('woocommerce/variation/details/'.$product_variation->id)}}" data-toggle="tooltip" data-placement="top" title="View"><i class="fa fa-eye" aria-hidden="true"></i></a></div>
                                                        <div class="align-items-center mr-2" data-toggle="tooltip" data-placement="top" title="Shelf View"><a class="btn-size btn-success" href="#" data-toggle="modal" data-target="#myModal{{$product_variation->id}}"><i class="fa fa-shopping-basket"></i></a></div>
{{--                                                        <div class="align-items-center mr-2"><a class="btn-success btn-size invoice-btn-size" href="{{url('catalogue-product-invoice-receive/'.$product_variation->product_draft->id.'/'.$product_variation->id)}}" target="_blank" data-toggle="tooltip" data-placement="top" title="Receive Invoice"><img src="{{asset('assets/images/receive-invoice.png')}}" width="30" height="30" class="filter"></a></div>--}}
{{--                                                        <div class="align-items-center mr-2"><a class="btn-size btn-success" href="{{url('print-barcode/'.$product_variation->id)}}" data-toggle="tooltip" data-placement="top" title="Click to print" target="_blank"><i class="fa fa-print"></i></a></div>--}}
                                                        <div class="align-items-center mr-2">
                                                            <form action="{{url('woocommerce/variation/delete/'.$product_variation->id)}}" method="post">
                                                                @csrf
                                                                <button class="del-pub btn-danger" href="" class="on-default remove-row" style="cursor: pointer" data-toggle="tooltip" data-placement="top" title="Delete" onclick="return check_delete('product');"><i class="fa fa-trash" aria-hidden="true"></i></button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </td>
                                                <div class="modal fade" id="myModal{{$product_variation->id}}">
                                                    <div class="modal-dialog modal-lg">
                                                        <div class="modal-content">

                                                            <!-- Modal Header -->
                                                            <div class="modal-header">
                                                                <h4 class="modal-title">Shelf Product</h4>
                                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                            </div>

                                                            <!-- Modal body -->
                                                            <div class="modal-body">
                                                                <div class="row">
                                                                    <div class="col-12">
                                                                        <div class="p-2 m-t-5 m-b-5 m-l-5 m-r-5">
                                                                            <div style="border: 1px solid #ccc;">
                                                                                <div class="row m-t-10">
                                                                                    <div class="col-4 text-center">
                                                                                        <h6> Shelf Name </h6>
                                                                                        <hr width="60%">
                                                                                    </div>
                                                                                    <div class="col-4 text-center">
                                                                                        <h6>Quantity</h6>
                                                                                        <hr width="60%">
                                                                                    </div>
                                                                                    <div class="col-4 text-center">
                                                                                        <h6>Action</h6>
                                                                                        <hr width="60%">
                                                                                    </div>
                                                                                </div>
                                                                                @foreach($product_variation->master_variation->shelf_quantity as $shelf)
                                                                                    @if($shelf->pivot->quantity != 0)
                                                                                        <div class="row">
                                                                                            <div class="col-4 text-center m-b-10">
                                                                                                <h7> {{$shelf->shelf_name}} </h7>
                                                                                            </div>
                                                                                            <div class="col-4 text-center m-b-10">
                                                                                                <h7 class="qnty_{{$product_variation->id}}_{{$shelf->pivot->id}}"> {{$shelf->pivot->quantity}} </h7>
                                                                                            </div>
                                                                                            <div class="col-4 text-center m-b-10">
                                                                                                <button type="button" class="btn btn-primary btn-sm change_quantity" id="{{$product_variation->id}}_{{$shelf->pivot->id}}">Change Quantity</button>
                                                                                            </div>
                                                                                        </div>
                                                                                    @endif
                                                                                @endforeach
                                                                                <div class="row p-20 change_quantity_div" style="display: none;">
                                                                                    <div class="col-12">
                                                                                        {{--                                                                                     <form action="Javascript:void(0);">--}}
                                                                                        <h3>Change Info:</h3><span></span>
                                                                                        <hr>
                                                                                        <div class="form-group">
                                                                                            <label class="required">Quantity</label>
                                                                                            <input type="text" class="form-control c_quantity_{{$product_variation->id}}" name="c_quantity" id="">
                                                                                        </div>
                                                                                        <div class="form-group">
                                                                                            <label for="">Reason</label>
                                                                                            <textarea class="form-control" name="c_reason" id="c_reason" cols="5" rows="3"></textarea>
                                                                                        </div>

                                                                                        <button type="button" class="btn btn-success">Add</button>
                                                                                        {{--                                                                                     </form>--}}
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div> <!-- end card -->
                                                                    </div> <!-- end col-12 -->
                                                                </div> <!-- end row -->
                                                            </div>

                                                            <!-- Modal footer -->
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-danger shadow" data-dismiss="modal">Close</button>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>  <!-- // The Modal -->
                                            </tr>
                                        @endif
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <!--table footer pagination sec-->
                            <div class="row table-foo-sec">
                                <div class="col-md-6 d-flex justify-content-md-start align-items-center">
                                    {{--                                    <div class="py-2">--}}
                                    {{--                                        <span class="font-bold float-lg-left" style="color: rgba(0, 0, 0, 0.44);"> Showing : {{$product_drafts_info->from}}-{{$product_drafts_info->to}} entries</span>--}}
                                    {{--                                    </div>--}}
                                </div>
                                <div class="col-md-6">
                                    <div class="d-flex justify-content-md-end align-items-center py-2">
                                        {{--                                        {{$product_drafts->links()}}--}}
                                        <div class="pagination-area">
                                            <div class="datatable-pages d-flex align-items-center">
                                                <span class="displaying-num">Product list {{$total_variation}} items</span>
                                                <span class="pagination-links d-flex">
                                                    <a class="first-page btn" href="#" data-toggle="tooltip" data-placement="top" title="First Page">
                                                        <span class="screen-reader-text d-none">First page</span>
                                                        <span aria-hidden="true">«</span>
                                                    </a>
                                                    <a class="prev-page btn" href="#" data-toggle="tooltip" data-placement="top" title="Previous Page">
                                                        <span class="screen-reader-text d-none">Previous page</span>
                                                        <span aria-hidden="true">‹</span>
                                                    </a>
                                                    <span class="screen-reader-text" style="display: none;">Current Page</span>
                                                    <span class="paging-input d-flex align-items-center">
                                                        <span class="datatable-paging-text  d-flex"> 1 of <span class="total-pages">3</span></span>
                                                    </span>
                                                    <a class="next-page btn" href="#" data-toggle="tooltip" data-placement="top" title="Next Page">
                                                        <span class="screen-reader-text d-none">Next page</span>
                                                        <span aria-hidden="true">›</span>
                                                    </a>
                                                    <a class="last-page btn" href="#" data-toggle="tooltip" data-placement="top" title="Last Page">
                                                        <span class="screen-reader-text d-none">Last page</span>
                                                        <span aria-hidden="true">»</span>
                                                    </a>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--End table footer pagination sec-->

                        </div>
                    </div> <!-- end row -->

                </div> <!-- end card box -->
            </div> <!-- container -->
        </div> <!-- content -->
    </div>  <!-- content page -->


    <script type="text/javascript">

        function search_variation(){
            var sku = $('#sku').val();
            if(sku == '' ){
                alert('Please type sku in the search field.');
                return false;
            }
            $.ajax({
                type: 'POST',
                url: '{{url('search-variation-list').'?_token='.csrf_token()}}',
                data: {
                    "sku" : sku,
                },
                beforeSend: function () {
                    console.log(sku);
                    $('#ajax_loader').show();
                },
                success: function (response) {
                    $('.variation_search_result').html(response);
                },
                complete: function () {
                    $('#ajax_loader').hide();
                }
            });
        }
        $(document).ready(function() {

            // Default Datatable
            // $('#datatable').DataTable();

            $('#search_variation').on('click',function () {

                console.log('found');
            });

            $('button.change_quantity').on('click',function () {
                var id = $(this).attr('id');
                var id_split = id.split('_');
                $('#myModal'+id_split[0]+' .change_quantity_div input.c_quantity_'+id_split[0]).attr('id','c_quantity_'+id);
                $('#myModal'+id_split[0]+' .change_quantity_div button').attr('id',id);
                $('#myModal'+id_split[0]+' .change_quantity_div span').attr('id',id);
                console.log(id);
                $('#myModal'+id_split[0]+' .change_quantity_div').slideToggle();
            });

            $('.change_quantity_div button').on('click',function () {
                var full_id = $(this).attr('id');
                var id = full_id.split('_');
                var variation_id = id[0];
                var product_shelf_id = id[1];
                var quantity = $('#myModal'+variation_id+' .change_quantity_div input#c_quantity_'+full_id).val();
                if(quantity == ''){
                    alert('Please give change quantity.');
                    return false;
                }
                var reason = $('#myModal'+variation_id+' .change_quantity_div textarea#c_reason').val();
                console.log(variation_id+'/'+quantity+'/'+reason);

                $.ajax({
                    type: "POST",
                    url: "{{url('shelf_quantity_update')}}",
                    data: {
                        "_token" : "{{csrf_token()}}",
                        "product_shelf_id" : product_shelf_id,
                        "quantity" : quantity,
                        "reason" : reason
                    },
                    success: function (response) {
                        if(response.data == true){
                            console.log(response.data);
                            $('.qnty_'+full_id).text(quantity);
                            $('#myModal'+variation_id+' .change_quantity_div span#'+full_id).addClass('text-success').html('Quantity updated successfully.')
                            $('#myModal'+variation_id+' .change_quantity_div input#c_quantity_'+full_id).val('');
                            $('#myModal'+variation_id+' .change_quantity_div textarea#c_reason').val('');
                        }
                    }
                });
            });

        } );






        //Datatable row-wise searchable option
        $(document).ready(function(){
            $("#row-wise-search").on("keyup", function() {
                let value = $(this).val().toLowerCase();
                $("#table-body tr").filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });

            });
        });

        //table header-search option toggle
        // $(document).ready(function(){
        //     $(".header-search").click(function(){
        //         $(".header-search-content").toggle();
        //     });
        // });

        //screen option toggle
        $(document).ready(function(){
            $(".screen-option-btn").click(function(){
                $(".screen-option-content").toggle();
            });
        });

        // table column hide and show toggle checkbox
        $("input:checkbox").click(function(){
            let column = "."+$(this).attr("name");
            $(column).toggle();
        });

        //table column by default hide
        $("input:checkbox:not(:checked)").each(function() {
            var column = "table ." + $(this).attr("name");
            $(column).hide();
        });


        // Entire table row column display
        $("#display-all").click(function(){
            $("table tr th, table tr td").show();
            $(".column-display .checkbox input[type=checkbox]").prop("checked", "true");
        });


        // After unchecked any column display all checkbox will be unchecked
        $(".column-display .checkbox input[type=checkbox]").change(function(){
            if (!$(this).prop("checked")){
                $("#display-all").prop("checked",false);
            }
        });


    </script>



    {{--    <script>--}}

    {{--        //Datatable row-wise searchable option--}}
    {{--        $(document).ready(function(){--}}
    {{--            $("#row-wise-search").on("keyup", function() {--}}
    {{--                let value = $(this).val().toLowerCase();--}}
    {{--                $("#table-body tr").filter(function() {--}}
    {{--                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)--}}
    {{--                });--}}

    {{--            });--}}
    {{--        });--}}


    {{--        //sort ascending and descending table rows js--}}
    {{--        function sortTable(n) {--}}
    {{--            let table,--}}
    {{--                rows,--}}
    {{--                switching,--}}
    {{--                i,--}}
    {{--                x,--}}
    {{--                y,--}}
    {{--                shouldSwitch,--}}
    {{--                dir,--}}
    {{--                switchcount = 0;--}}
    {{--            table = document.getElementById("table-sort-list");--}}
    {{--            switching = true;--}}
    {{--            //Set the sorting direction to ascending:--}}
    {{--            dir = "asc";--}}
    {{--            /*Make a loop that will continue until--}}
    {{--            no switching has been done:*/--}}
    {{--            while (switching) {--}}
    {{--                //start by saying: no switching is done:--}}
    {{--                switching = false;--}}
    {{--                rows = table.getElementsByTagName("TR");--}}
    {{--                /*Loop through all table rows (except the--}}
    {{--                first, which contains table headers):*/--}}
    {{--                for (i = 1; i < rows.length - 1; i++) { //Change i=0 if you have the header th a separate table.--}}
    {{--                    //start by saying there should be no switching:--}}
    {{--                    shouldSwitch = false;--}}
    {{--                    /*Get the two elements you want to compare,--}}
    {{--                    one from current row and one from the next:*/--}}
    {{--                    x = rows[i].getElementsByTagName("TD")[n];--}}
    {{--                    y = rows[i + 1].getElementsByTagName("TD")[n];--}}
    {{--                    /*check if the two rows should switch place,--}}
    {{--                    based on the direction, asc or desc:*/--}}
    {{--                    if (dir == "asc") {--}}
    {{--                        if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {--}}
    {{--                            //if so, mark as a switch and break the loop:--}}
    {{--                            shouldSwitch = true;--}}
    {{--                            break;--}}
    {{--                        }--}}
    {{--                    } else if (dir == "desc") {--}}
    {{--                        if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {--}}
    {{--                            //if so, mark as a switch and break the loop:--}}
    {{--                            shouldSwitch = true;--}}
    {{--                            break;--}}
    {{--                        }--}}
    {{--                    }--}}
    {{--                }--}}
    {{--                if (shouldSwitch) {--}}
    {{--                    /*If a switch has been marked, make the switch--}}
    {{--                    and mark that a switch has been done:*/--}}
    {{--                    rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);--}}
    {{--                    switching = true;--}}
    {{--                    //Each time a switch is done, increase this count by 1:--}}
    {{--                    switchcount++;--}}
    {{--                } else {--}}
    {{--                    /*If no switching has been done AND the direction is "asc",--}}
    {{--                    set the direction to "desc" and run the while loop again.*/--}}
    {{--                    if (switchcount == 0 && dir == "asc") {--}}
    {{--                        dir = "desc";--}}
    {{--                        switching = true;--}}
    {{--                    }--}}
    {{--                }--}}
    {{--            }--}}
    {{--        }--}}


    {{--        // sort ascending descending icon active and active-remove js--}}
    {{--        $('.header-cell').click(function() {--}}
    {{--            let isSortedAsc  = $(this).hasClass('sort-asc');--}}
    {{--            let isSortedDesc = $(this).hasClass('sort-desc');--}}
    {{--            let isUnsorted = !isSortedAsc && !isSortedDesc;--}}

    {{--            $('.header-cell').removeClass('sort-asc sort-desc');--}}

    {{--            if (isUnsorted || isSortedDesc) {--}}
    {{--                $(this).addClass('sort-asc');--}}
    {{--            } else if (isSortedAsc) {--}}
    {{--                $(this).addClass('sort-desc');--}}
    {{--            }--}}
    {{--        });--}}

    {{--    </script>--}}




@endsection
