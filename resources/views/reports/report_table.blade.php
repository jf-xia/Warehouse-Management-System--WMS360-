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
                <div class="wms-breadcrumb-middle">
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
                                <div class="col-lg-6" style="display: inline-block;">
                                    <h4>Total Sold</h4>
                                    <h2>{{$sold}}</h2>
                                </div>
                                <div class="col-lg-6" style="float:right;">
                                    <form action="{{URL('global_reports/download-sku-sold-report-csv')}}" method="POST">
                                        @csrf
                                        <input type="hidden" value="{{$csv_predefine_date}}" name="predefine_date">
                                        <input type="hidden" value="{{$csv_start_date}}" name="start_date">
                                        <input type="hidden" value="{{$csv_end_date}}" name="end_date">
                                        <input type="hidden" value="{{$csv_sku}}" name="sku">
                                        <input type="hidden" value="{{$csv_accounts}}" name="accounts">
                                    <button class="waves-effect waves-light" type="submit" style="float: right; background: green; padding: 10px; color: #fff; border: none;">Download CSV</button>
                                    </form>
                                </div>
                                <table class="draft_search_result product-draft-table w-100 ">
                                    <thead style="background-color: {{$setting->master_publish_catalogue->table_header_color ?? '#c5bdbd'}}; color: {{$setting->master_publish_catalogue->table_header_text_color ?? '#292424'}}">
                                        <tr>
                                            <th>Name</th>
                                            <th>SKU</th>
                                            <th>Variation ID</th>
                                            <th>Catalogue ID</th>
                                            <th>Order ID</th>
                                            <th>Order Number</th>
                                            <th>Order Date</th>
                                            <th>Sold</th>
                                        </tr>
                                    </thead>
                                    <tbody id="search_reasult" class="scrollbar-lg">
                                    @foreach($all_value as $key=> $product_draft)
                                        @if(isset($product_draft[0]->productOrders[0]))
                                            @php
                                            $order_date = date('d-m-Y', strtotime($product_draft[0]->date_created));
                                            @endphp
                                        <tr>
                                            @if($key == 0)
                                                <td>{{$product_draft[0]->productOrders[0]->pivot->name}}</td>
                                                <td>{{$product_draft[0]->productOrders[0]->sku}}</td>
                                                <td>{{$product_draft[0]->productOrders[0]->pivot->variation_id}}</td>
                                                <td>{{$product_draft[0]->productOrders[0]->product_draft_id}}</td>
                                            @else
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                            @endif
                                            <td>{{$product_draft[0]->id}}</td>
                                            <td>{{$product_draft[0]->order_number}}</td>
                                            <td>{{$order_date}}</td>
                                            <td>{{$product_draft[0]->productOrders[0]->pivot->quantity}}</td>
                                        </tr>
                                        @endif
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>



                        </div> <!--//End card-box -->
                    </div><!--//End col-md-12 -->
                </div><!--//End row -->
            </div> <!-- // End Container-fluid -->
        </div> <!-- // End Content -->
    </div> <!-- // End Contact page -->
    <script>
        // Select option dropdown
        $('.select2').select2();
        $(".unsold_cat_sku_account").select2({
            placeholder: "All Account",
        });

        function getVariation(e){
            var product_draft_id = e.id;
            product_draft_id = product_draft_id.split('-');
            var id = product_draft_id[1]
            var searchKeyword = $('input#name').val();


            $.ajax({
                type: "post",
                url: "<?php echo e(url('get-variation')); ?>",
                data: {
                    "_token" : "<?php echo e(csrf_token()); ?>",
                    "product_draft_id" : id,
                    "searchKeyword" : searchKeyword

                },
                beforeSend: function () {
                    $('#product_variation_loading'+id).show();
                },
                success: function (response) {
                    // $('#datatable_wrapper div:first').hide();
                    // $('#datatable_wrapper div:last').hide();
                    // $('.product-content ul.pagination').hide();
                    // $('.total-d-o span').hide();
                    // $('.draft_search_result').html(response.data);

                    $('#demo'+id).html(response);
                },
                complete: function () {
                    $('#product_variation_loading'+id).hide();
                }
            })
        }

    </script>

@endsection
