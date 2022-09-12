@extends('master')
@section('title')
    Catalogue | Unmatched Product | WMS360
@endsection
@section('content')
    <div class="content-page">
        <!-- Start content -->
        <div class="content">


            <div class="container-fluid">

                <div class="d-flex justify-content-between align-items-center">

                    <ol class="breadcrumb page-breadcrumb">
                        <li class="breadcrumb-item">Inventory</li>
                        <li class="breadcrumb-item active" aria-current="page">Unmatched Quantity</li>
                    </ol>

                </div>


                <!-- Page-Title -->
                <div id="Load" class="load" style="display: none;">
                    <div class="load__container">
                        <div class="load__animation"></div>
                        <div class="load__mask"></div>
                        <span class="load__title">Content is loading...</span>
                    </div>
                </div>


                <div class="row m-t-20">
                    <div class="row" >
                        <div style="float: left">
                            <form id="upload_csv" method="post" enctype="multipart/from-data">
                                @csrf
                                <div class="form-row">

                                    <div class="col-12">

                                        <div class="col-6" style="float: left;padding-left: 5%">
                                            {{--                                                    <label for="uploadcsv">Create Order via CSV file</label>--}}
                                            <input type="file"  name="csvFile" id="csvFile" accept=".csv" required>
                                            {{--                                                    <label class="custom-file-label" for="validatedCustomFile" style="margin-top:26px;">Choose file...</label>--}}

                                        </div>
                                        <div class="col-6" style="float: left; padding-bottom: 2%;" >
                                            <label for="validationDefault01"></label>
                                            <!-- <a class="btn btn-default manual-btn-csv" href="#csvSubmitModal" data-animation="slit" data-plugin="custommodal" data-overlaySpeed="100" data-overlayColor="#36404a" data-placement="top">Submit</a> -->
                                            <button class="btn btn-rounded btn-active">Submit</button>
                                        </div>
                                        <div style="padding-left: 5%">
                                            <label>Upload CSV To Chek Quantity <a href="{{URL::to('/check_quantity_sample.csv')}}">sample csv</a></label>
                                        </div>

                                    </div>
                                    {{--                                            <button type="submit" class="btn btn-default manual-btn-csv">Submit</button>--}}

                                </div>
                                {{--                                        <a href="{{asset('assets/common-assets/sample.csv')}}" class="float-right" style="margin-right:20px; margin-bottom:20px;">Download the sample csv file</a>--}}
                            </form>
                        </div>
                    </div>

                    <div class="col-md-12">

                        <div class="shadow">
                            <ul class="nav nav-tabs" role="tablist">
                                @if($shelf_use == 1)
                                    <li class="nav-item text-center" style="width: 33.33%">
                                        <a class="nav-link active" data-toggle="tab" href="#larger_available_quantity">Available
                                            and Shelf Quantity Unmatched List</a>
                                    </li>
                                    <li class="nav-item text-center" style="width: 33.33%">
                                        <a class="nav-link" data-toggle="tab" href="#threshold_product">Threshold Product
                                            List</a>
                                    </li>
                                @endif
                                <li class="nav-item text-center" style="width: @if($shelf_use == 1) 33.33% @else 100% @endif">
                                    <a class="nav-link @if($shelf_use == 0) active @endif" data-toggle="tab" href="#negative_quantity">Negative Quantity
                                        Product</a>
                                </li>
                            </ul>

                            <div class="tab-content p-50 product-content">
                                @if($shelf_use == 1)
                                <div id="larger_available_quantity" class="tab-pane active m-b-20">
                                    <h5 class="text-center">Larger Available Quantity ({{count($all_variation_info ?? [])}}
                                        )</h5>
                                    <div class="product-inner p-b-10">
                                        <div class="table-list"></div>
                                        <div class="row-wise-search table-terms">
                                            <input class="form-control mb-1" id="row-wise-search" type="text"
                                                   placeholder="Search....">
                                        </div>
                                    </div>

                                    <div class="table-responsive">
                                        <table id="table-sort-list" class="table table-hover table-bordered">
                                            <thead>
                                            <tr>
                                                <th class="header-cell" onclick="first_tab_sortTable(0)">Image</th>
                                                <th class="header-cell" onclick="first_tab_sortTable(0)">ID</th>
                                                <th class="header-cell" onclick="first_tab_sortTable(0)">SKU</th>
                                                <th class="header-cell" onclick="first_tab_sortTable(0)">Available Qty</th>
                                                <th class="header-cell" onclick="first_tab_sortTable(0)">Shelf Qty</th>
                                                <th class="header-cell" onclick="first_tab_sortTable(0)">Name</th>
                                            </tr>
                                            </thead>
                                            <tbody id="table-body">
                                            @isset($all_variation_info)
                                                @foreach($all_variation_info as $product_variation)
                                                    <tr>
                                                        <td>
                                                            <a href="{{$product_variation['image'] ?? ((filter_var($product_variation['master_image'], FILTER_VALIDATE_URL) == FALSE) ? asset('/').$product_variation['master_image'] : $product_variation['master_image'])}}"
                                                               target="_blank">
                                                                <img
                                                                    src="{{$product_variation['image'] ?? ((filter_var($product_variation['master_image'], FILTER_VALIDATE_URL) == FALSE) ? asset('/').$product_variation['master_image'] : $product_variation['master_image'])}}"
                                                                    height="50" width="50">
                                                            </a>
                                                        </td>
                                                        <td>{{$product_variation['id'] ?? ''}}</td>
                                                        <td>{{$product_variation['sku'] ?? ''}}</td>
                                                        <td>{{$product_variation['actual_quantity'] ?? ''}}</td>
                                                        <td>{{$product_variation['shelf_quantity'] ?? ''}}</td>
                                                        <td><a href="{{asset('product-draft/'.$product_variation['master_catalogue_id'])}}" target="_blank">{{$product_variation['name'] ?? ''}}</td>
                                                    </tr>
                                                @endforeach
                                            @endisset
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div id="threshold_product" class="tab-pane fade m-b-20">
                                    <h5 class="text-center">Threshold Product
                                        (<span>{{count($shelve_qnty_larger_than_available ?? [])}}</span>)</h5>
                                    <h6 class="text-center">Threshold Value by default -> <span
                                            class="text-success">{{$threshold_quantity ?? 0}}</span></h6>
                                    <div class="btn-group m-b-10">
                                        <input type="number" class="form-control" name="threshold_value" value="5"
                                               placeholder="Search by your threshold value...">
                                        <button id="search_threshold" type="button" class="btn btn-purple btn-sm">search</button>
                                    </div>
                                    <div class="thresholdProductMessage"></div>

                                    <div class="table-responsive">
                                        <table id="table-sort-list-1" class="table table-hover table-bordered">
                                            <thead>
                                            <tr>
                                                <th class="header-cell" onclick="second_tab_sortTable(0)">Image</th>
                                                <th class="header-cell" onclick="second_tab_sortTable(0)">ID</th>
                                                <th class="header-cell" onclick="second_tab_sortTable(0)">SKU</th>
                                                <th class="header-cell" onclick="second_tab_sortTable(0)">Available Qty</th>
                                                <th class="header-cell" onclick="second_tab_sortTable(0)">Shelf Qty</th>
                                                <th class="header-cell" onclick="second_tab_sortTable(0)">Name</th>
                                            </tr>
                                            </thead>
                                            <tbody id="table-body-1">
                                            @isset($shelve_qnty_larger_than_available)
                                                @foreach($shelve_qnty_larger_than_available as $product_variation)
                                                    <tr>
                                                        <td>
                                                            <a href="{{$product_variation['image'] ?? ((filter_var($product_variation['master_image'], FILTER_VALIDATE_URL) == FALSE) ? asset('/').$product_variation['master_image'] : $product_variation['master_image'])}}"
                                                               target="_blank">
                                                                <img
                                                                    src="{{$product_variation['image'] ?? ((filter_var($product_variation['master_image'], FILTER_VALIDATE_URL) == FALSE) ? asset('/').$product_variation['master_image'] : $product_variation['master_image'])}}"
                                                                    height="50" width="50">
                                                            </a>
                                                        </td>
                                                        <td>{{$product_variation['id'] ?? ''}}</td>
                                                        <td>{{$product_variation['sku'] ?? ''}}</td>
                                                        <td>{{$product_variation['actual_quantity'] ?? ''}}</td>
                                                        <td>{{$product_variation['shelf_quantity'] ?? ''}}</td>
                                                        <td><a href="{{asset('product-draft/'.$product_variation['master_catalogue_id'])}}" target="_blank">{{$product_variation['name'] ?? ''}}</a></td>
                                                    </tr>
                                                @endforeach
                                            @endisset
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                @endif
                                <div id="negative_quantity" class="tab-pane @if($shelf_use == 0) active @else fade @endif m-b-20">
                                    <h5 class="text-center">Neagtive Quantity
                                        (<span>{{count($negative_quantity ?? [])}}</span>)</h5>
                                    <div class="table-responsive">
                                        <table id="datatable" class="table table-hover table-bordered">
                                            <thead>
                                            <tr>
                                                <th>Image</th>
                                                <th>ID</th>
                                                <th>SKU</th>
                                                <th>Available Qty</th>
                                                @if($shelf_use == 1)
                                                    <th>Shelf Qty</th>
                                                @endif
                                                <th>Name</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @isset($negative_quantity)
                                                @foreach($negative_quantity as $product_variation)
                                                    <tr>
                                                        <td>
                                                            @if(isset($product_variation->product_draft->single_image_info->image_url))
                                                            <a href="{{$product_variation->image ?? ((filter_var($product_variation->product_draft->single_image_info->image_url, FILTER_VALIDATE_URL) == FALSE) ? asset('/').$product_variation->product_draft->single_image_info->image_url : $product_variation->product_draft->single_image_info->image_url)}}"
                                                               target="_blank">
                                                                <img
                                                                    src="{{$product_variation->image ?? ((filter_var($product_variation->product_draft->single_image_info->image_url, FILTER_VALIDATE_URL) == FALSE) ? asset('/').$product_variation->product_draft->single_image_info->image_url : $product_variation->product_draft->single_image_info->image_url)}}"
                                                                    height="50" width="50">
                                                            </a>
                                                            @else
                                                                <img src="{{asset('assets/common-assets/no_image.jpg')}}" class="thumb-md" title="No img available" alt="Unmatched-product-image">
                                                            @endif
                                                        </td>
                                                        <td>{{$product_variation->id ?? ''}}</td>
                                                        <td>{{$product_variation->sku ?? ''}}</td>
                                                        <td>{{$product_variation->actual_quantity ?? ''}}</td>
                                                        @if($shelf_use == 1)
                                                            <td>
                                                                @isset($product_variation->shelf_quantity)
                                                                    @php
                                                                        $total = 0;
                                                                    @endphp
                                                                    @foreach($product_variation->shelf_quantity as $shelf)
                                                                        @php
                                                                            $total += $shelf->pivot->quantity;
                                                                        @endphp
                                                                    @endforeach
                                                                @endisset
                                                                {{$total ?? 0}}
                                                            </td>
                                                        @endif
                                                        <td><a href="{{asset('product-draft/'.$product_variation->product_draft_id)}}" target="_blank">{{$product_variation->product_draft->name ?? ''}}</a></td>
                                                    </tr>
                                                @endforeach
                                            @endisset
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> <!-- end col -->
                </div>
                <!-- end col -->
            </div>
        </div> <!-- container -->

    </div> <!-- content -->

    <script>
        $(document).ready(function () {
            $('#upload_csv').on('submit', function(event){

                event.preventDefault();
                var submitLoadingButton = $('button.manual-btn-csv')
                // submitLoadingButton.html('<i class="fa fa-circle-o-notch fa-spin"></i> Submitting...')
                var fileName = $('#csvFile')[0].files[0].name
                var extension = fileName.substr(fileName.lastIndexOf('.') + 1);

                if(extension != 'csv'){
                    Swal.fire('Oops!','Only CSV file allowed','error')
                    submitLoadingButton.html('Submit');
                    return false
                }
                $.ajax({
                    url: "{{url('check-ebay-product-quantity')}}",
                    method:"POST",
                    data:new FormData(this),
                    dataType:'json',
                    contentType:false,
                    cache:false,
                    processData:false,
                    beforeSend: function () {
                        $('#ajax_loader').show();
                    },
                    success: function(response){
                        var filename= response;
                        var location_url ="{{URL::to('/')}}"+'/'+ filename;
                        window.location.href = location_url;
                    },complete: function () {
                        $('#ajax_loader').hide();
                    }
                })

            })
            $('.dataTables_length').addClass('bs-select');
            $('#search_threshold').click(function () {
                var threshold_value = $('input[name=threshold_value]').val();
                if (isNaN(threshold_value) || threshold_value == '' || threshold_value == 0 || threshold_value < 1) {
                    alert('Please input valid your threshold value');
                    return false;
                }
                $.ajax({
                    type: "post",
                    url: "{{url('search-threshold-unmatched-product')}}",
                    data: {
                        "_token": "{{csrf_token()}}",
                        "threshold_value": threshold_value
                    },
                    beforeSend: function () {
                        $('#ajax_loader').show();
                    },
                    success: function (response) {
                        if(response.data != 'error') {
                            $('#datatable_wrapper').children().not("div:nth-child(2)").hide();
                            $('#threshold_product h5 span').html(response.row);
                            $('#threshold_product h6').html('Search threshold value -> <span class="text-success">' + threshold_value + '</span>');
                            $('#threshold_product table tbody').html(response.data);
                        }else{
                            $('.thresholdProductMessage').addClass('text-danger').html('Something went wrong');
                        }
                    },
                    complete: function () {
                        $('#ajax_loader').hide();
                    }
                });
            });
        });

    </script>

    <script>
        //Datatable row-wise searchable option 1st Tab
        $(document).ready(function () {
            $("#row-wise-search").on("keyup", function () {
                let value = $(this).val().toLowerCase();
                $("#table-body tr").filter(function () {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
            });
        });
        //Datatable row-wise searchable option 2nd Tab
        $(document).ready(function () {
            $("#row-wise-search-1").on("keyup", function () {
                let value = $(this).val().toLowerCase();
                $("#table-body-1 tr").filter(function () {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
            });
        });

        //sort ascending and descending table rows js 1st Tab
        function first_tab_sortTable(n) {
            let table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
            table = document.getElementById("table-sort-list");
            switching = true;
            dir = "asc";
            while (switching) {
                switching = false;
                rows = table.getElementsByTagName("TR");
                for (i = 1; i < rows.length - 1; i++) {
                    shouldSwitch = false;
                    x = rows[i].getElementsByTagName("TD")[n];
                    y = rows[i + 1].getElementsByTagName("TD")[n];
                    if (dir == "asc") {
                        if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
                            shouldSwitch = true;
                            break;
                        }
                    } else if (dir == "desc") {
                        if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
                            shouldSwitch = true;
                            break;
                        }
                    }
                }
                if (shouldSwitch) {
                    rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
                    switching = true;
                    switchcount++;
                } else {
                    if (switchcount == 0 && dir == "asc") {
                        dir = "desc";
                        switching = true;
                    }
                }
            }
        }

        //sort ascending and descending table rows js 2nd Tab
        function second_tab_sortTable(n) {
            let table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
            table = document.getElementById("table-sort-list-1");
            switching = true;
            dir = "asc";
            while (switching) {
                switching = false;
                rows = table.getElementsByTagName("TR");
                for (i = 1; i < rows.length - 1; i++) {
                    shouldSwitch = false;
                    x = rows[i].getElementsByTagName("TD")[n];
                    y = rows[i + 1].getElementsByTagName("TD")[n];
                    if (dir == "asc") {
                        if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
                            shouldSwitch = true;
                            break;
                        }
                    } else if (dir == "desc") {
                        if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
                            shouldSwitch = true;
                            break;
                        }
                    }
                }
                if (shouldSwitch) {
                    rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
                    switching = true;
                    switchcount++;
                } else {
                    if (switchcount == 0 && dir == "asc") {
                        dir = "desc";
                        switching = true;
                    }
                }
            }
        }

        // sort ascending descending icon active and active-remove js
        $('.header-cell').click(function () {
            let isSortedAsc = $(this).hasClass('sort-asc');
            let isSortedDesc = $(this).hasClass('sort-desc');
            let isUnsorted = !isSortedAsc && !isSortedDesc;

            $('.header-cell').removeClass('sort-asc sort-desc');

            if (isUnsorted || isSortedDesc) {
                $(this).addClass('sort-asc');
            } else if (isSortedAsc) {
                $(this).addClass('sort-desc');
            }
        });
    </script>
@endsection
