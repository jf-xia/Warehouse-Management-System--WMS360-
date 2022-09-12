
@extends('master')
@section('title')
    {{$page_title}}
@endsection
@section('content')
    <div class="content-page">
        <!-- Start content -->
        <div class="content">
            <div class="container-fluid">
                <!--screen option-->
                <div class="row">
                    <div class="col-md-12">
                        <div class="card-box screen-option-content" style="display: none">
                            <!----ON OFF SWITCH ARRAY KEY DECLARATION---->
                            <input type="hidden" id="firstKey" value="available_quantity">
                            <input type="hidden" id="secondKey" value="available_quantity_change_log">
                            <!----END ON OFF SWITCH ARRAY KEY DECLARATION---->


                            <!--Pagination Count and Apply Button Section-->
                            <div class="d-flex justify-content-between">
                                <div>
                                    <div><p class="pagination"><b>Pagination</b></p></div>
                                    <ul class="column-display d-flex align-items-center">
                                        <li>Number of items per page</li>
                                        <li>
                                            <input type="number" class="pagination-count" value="{{$pagination ?? 0}}">
                                        </li>
                                    </ul>
                                    <span class="pagination-mgs-show text-success"></span>
                                    <div class="submit">
                                        <input type="submit" class="btn submit-btn pagination-apply" value="Apply">
                                    </div>
                                </div>
                            </div>
                            <!--End Pagination Count and Apply Button Section-->

                        </div>
                    </div>
                </div>
                <!--//screen option-->

                <!--Breadcrumb section-->
                <div class="screen-option">
                    <div class="d-flex justify-content-start align-items-center">
                        <ol class="breadcrumb page-breadcrumb">
                            <li class="breadcrumb-item"> Product </li>
                            <li class="breadcrumb-item active" aria-current="page"> Available Quantity Change Log </li>
                        </ol>
                    </div>
                    <div class="screen-option-btn">
                        <button class="btn btn-link waves-effect waves-light" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                            Screen Options &nbsp; <i class="fa" aria-hidden="true"></i>
                        </button>
                        <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion"></div>
                    </div>
                </div>
                <!--End Breadcrumb section-->

                   <!--Card box start-->
                   <div class="row m-t-20">
                        <div class="col-md-12">
                            <div class="card-box table-responsive shadow available-quantity-change-log-card">
                            <form action="{{url('all-column-search')}}" method="post">
                                    @csrf
                                <!--start table upper side content-->
                                <div class="d-flex justify-content-between product-inner p-b-10">
                                    <div class="row-wise-search search-terms">
                                        <input class="form-control mb-1" id="in-row-available-quantity-wise-search" type="text" name="input_search" placeholder="Search....">
                                    </div>
                                    <!--start pagination-->
                                    <div class="pagination-area mt-xs-10 mb-xs-5">
                                        <!-- <form action="{{url('pagination-all')}}" method="post">
                                            @csrf -->
                                            <div class="datatable-pages d-flex align-items-center">
                                                <span class="displaying-num">{{$allChangeLog->total()}} items</span>
                                                <span class="pagination-links d-flex">
                                                @if($allChangeLog->currentPage() > 1)
                                                <a class="first-page btn {{$allChangeLog->currentPage() > 1 ? '' : 'disable'}}" href="{{$all_decode_available_quantity_change_log->first_page_url}}" data-toggle="tooltip" data-placement="top" title="First Page">
                                                    <span class="screen-reader-text d-none">First page</span>
                                                    <span aria-hidden="true">«</span>
                                                </a>
                                                <a class="prev-page btn {{$allChangeLog->currentPage() > 1 ? '' : 'disable'}}" href="{{$all_decode_available_quantity_change_log->prev_page_url}}" data-toggle="tooltip" data-placement="top" title="Previous Page">
                                                    <span class="screen-reader-text d-none">Previous page</span>
                                                    <span aria-hidden="true">‹</span>
                                                </a>
                                                @endif
                                                <span class="paging-input d-flex align-items-center">
                                                    <label for="current-page-selector" class="screen-reader-text d-none">Current Page</label>
                                                    <input class="current-page" id="current-page-selector" type="text" name="page" value="{{$all_decode_available_quantity_change_log->current_page}}" size="3" aria-describedby="table-paging">
                                                    <span class="datatable-paging-text d-flex"> of <span class="total-pages">{{$all_decode_available_quantity_change_log->last_page}}</span></span>
                                                    <!-- <input type="hidden" name="route_name" value="available-quantity-change-log"> -->
                                                </span>
                                                @if($allChangeLog->currentPage() !== $allChangeLog->lastPage())
                                                <a class="next-page btn" href="{{$all_decode_available_quantity_change_log->next_page_url}}" data-toggle="tooltip" data-placement="top" title="Next Page">
                                                    <span class="screen-reader-text d-none">Next page</span>
                                                    <span aria-hidden="true">›</span>
                                                </a>
                                                <a class="last-page btn" href="{{$all_decode_available_quantity_change_log->last_page_url}}" data-toggle="tooltip" data-placement="top" title="Last Page">
                                                    <span class="screen-reader-text d-none">Last page</span>
                                                    <span aria-hidden="true">»</span>
                                                </a>
                                                @endif
                                            </span>
                                            </div>
                                        <!-- </form> -->
                                    </div>
                                    <!--End pagination-->
                                </div>
                                <!--End table upper side content-->


                                <!--start loader-->
                                <div id="Load" class="load" style="display: none;">
                                    <div class="load__container">
                                        <div class="load__animation"></div>
                                        <div class="load__mask"></div>
                                        <span class="load__title">Content is loading...</span>
                                    </div>
                                </div>
                                <!--End loader-->

                                <span class="search_result_show"></span> <!--message show-->

                                <!--start table section-->
                                <table class="shelf-quantity-change-log-table w-100">
                                    <!--start table head-->
                                    <thead>

                                    <input type="hidden" name="search_route" value="available-quantity-change-log">
                                    <input type="hidden" name="is_search" id="is_search" value="{{$isSearch}}">
                                    <tr>
                                        <th class="image text-center" style="width: 10%">
                                            <div class="d-flex justify-content-center">
                                                <div>Image</div>
                                            </div>
                                        </th>
                                        <th class="variation_id filter-symbol text-center" style="width: 10%">
                                            <div class="d-flex justify-content-center">
                                                <div class="btn-group">

                                                        <a type="button" class="dropdown-toggle filter-btn" data-toggle="dropdown">
                                                            <i class="fa" aria-hidden="true"></i>
                                                        </a>
                                                        <div class="dropdown-menu filter-content shadow" role="menu">
                                                            <p>Filter Value</p>
                                                            <input type="text" class="form-control input-text" name="variation_id" id="variation_id" onkeyup='saveValue(this);'>
                                                            <div class="checkbox checkbox-custom checkbox m-t-10 m-b-10">
                                                                <input id="opt-out4" type="checkbox" name="opt_out" value="1"><label for="opt-out4">Opt Out</label>
                                                            </div>
                                                            <!-- <input type="hidden" name="column_name" value="variation_id">
                                                            <input type="hidden" name="route_name" value="available-quantity-change-log"> -->
                                                            <button type="submit" class="btn btn-primary filter-apply-btn float-right">Apply <i class="fa fa-arrow-circle-right ml-1"></i></button>
                                                        </div>

                                                </div>
                                                <div>Product ID</div>
                                            </div>
                                        </th>
                                        <th class="title filter-symbol text-center" style="width: 20%">
                                            <div class="d-flex justify-content-start">
                                                <div class="btn-group">

                                                        <a type="button" class="dropdown-toggle filter-btn" data-toggle="dropdown">
                                                            <i class="fa" aria-hidden="true"></i>
                                                        </a>
                                                        <div class="dropdown-menu filter-content shadow" role="menu">
                                                            <p>Filter Value</p>
                                                            <input type="text" class="form-control input-text" name="title" id="title" onkeyup='saveValue(this);'>
                                                            <div class="checkbox checkbox-custom checkbox m-t-10 m-b-10">
                                                                <input id="opt-out4" type="checkbox" name="opt_out" value="1"><label for="opt-out4">Opt Out</label>
                                                            </div>
                                                            <!-- <input type="hidden" name="column_name" value="title">
                                                            <input type="hidden" name="route_name" value="available-quantity-change-log"> -->
                                                            <button type="submit" class="btn btn-primary filter-apply-btn float-right">Apply <i class="fa fa-arrow-circle-right ml-1"></i></button>
                                                        </div>

                                                </div>
                                                <div>Title</div>
                                            </div>
                                        </th>
                                        <th class="sku filter-symbol text-center" style="width: 10%">
                                            <div class="d-flex justify-content-start">
                                                <div class="btn-group">

                                                        <a type="button" class="dropdown-toggle filter-btn" data-toggle="dropdown">
                                                            <i class="fa" aria-hidden="true"></i>
                                                        </a>
                                                        <div class="dropdown-menu filter-content shadow" role="menu">
                                                            <p>Filter Value</p>
                                                            <input type="text" class="form-control input-text" name="sku" id="sku" onkeyup='saveValue(this);'>
                                                            <div class="checkbox checkbox-custom checkbox m-t-10 m-b-10">
                                                                <input id="opt-out4" type="checkbox" name="opt_out" value="1"><label for="opt-out4">Opt Out</label>
                                                            </div>
                                                            <!-- <input type="hidden" name="column_name" value="sku">
                                                            <input type="hidden" name="route_name" value="available-quantity-change-log"> -->
                                                            <button type="submit" class="btn btn-primary filter-apply-btn float-right">Apply <i class="fa fa-arrow-circle-right ml-1"></i></button>
                                                        </div>

                                                </div>
                                                <div>SKU</div>
                                            </div>
                                        </th>
                                        <th class="previous_quantity filter-symbol text-center" style="width: 10%">
                                            <div class="d-flex justify-content-center">
                                                <div class="btn-group">

                                                        <a type="button" class="dropdown-toggle filter-btn" data-toggle="dropdown">
                                                            <i class="fa" aria-hidden="true"></i>
                                                        </a>
                                                        <div class="dropdown-menu filter-content stock-filter-content shadow" role="menu">
                                                            <p>Filter Value</p>
                                                            <div class="d-flex">
                                                                <div>
                                                                    <select class="form-control" name="filter_option">
                                                                        <option value="=">=</option>
                                                                        <option value="<"><</option>
                                                                        <option value=">">></option>
                                                                        <option value="<=">≤</option>
                                                                        <option value=">=">≥</option>
                                                                    </select>
                                                                </div>
                                                                <div class="ml-2">
                                                                    <input type="text" class="form-control input-text symbol-filter-input-text" name="previous_quantity" id="previous_quantity" onkeyup='saveValue(this);'>
                                                                </div>
                                                            </div>
                                                            <div class="checkbox checkbox-custom checkbox m-t-10 m-b-10">
                                                                <input id="opt-out2" type="checkbox" name="opt_out" value="1"><label for="opt-out2">Opt Out</label>
                                                            </div>
                                                            <!-- <input type="hidden" name="column_name" value="previous_quantity">
                                                            <input type="hidden" name="route_name" value="available-quantity-change-log"> -->
                                                            <button type="submit" class="btn btn-primary filter-apply-btn float-right">Apply<i class="fa fa-arrow-circle-right ml-1"></i></button>
                                                        </div>

                                                </div>
                                                <div>Previous Quantity</div>
                                            </div>
                                        </th>
                                        <th class="updated_quantity filter-symbol text-center" style="width: 10%">
                                            <div class="d-flex justify-content-center">
                                                <div class="btn-group">

                                                        <a type="button" class="dropdown-toggle filter-btn" data-toggle="dropdown">
                                                            <i class="fa" aria-hidden="true"></i>
                                                        </a>
                                                        <div class="dropdown-menu filter-content stock-filter-content shadow" role="menu">
                                                            <p>Filter Value</p>
                                                            <div class="d-flex">
                                                                <div>
                                                                    <select class="form-control" name="filter_option">
                                                                        <option value="=">=</option>
                                                                        <option value="<"><</option>
                                                                        <option value=">">></option>
                                                                        <option value="<=">≤</option>
                                                                        <option value=">=">≥</option>
                                                                    </select>
                                                                </div>
                                                                <div class="ml-2">
                                                                    <input type="text" class="form-control input-text symbol-filter-input-text" id="updated_quantity" onkeyup='saveValue(this);' name="updated_quantity">
                                                                </div>
                                                            </div>
                                                            <div class="checkbox checkbox-custom checkbox m-t-10 m-b-10">
                                                                <input id="opt-out3" type="checkbox" name="opt_out" value="1"><label for="opt-out3">Opt Out</label>
                                                            </div>
                                                            <!-- <input type="hidden" name="column_name" value="updated_quantity">
                                                            <input type="hidden" name="route_name" value="available-quantity-change-log"> -->
                                                            <button type="submit" class="btn btn-primary filter-apply-btn float-right">Apply<i class="fa fa-arrow-circle-right ml-1"></i></button>
                                                        </div>

                                                </div>
                                                <div>Updated Quantity</div>
                                            </div>
                                        </th>

                                        <th class="modifier text-center" style="width: 10%">
                                            <div class="d-flex justify-content-center">
                                                <div class="btn-group">

                                                        <a type="button" class="dropdown-toggle filter-btn" data-toggle="dropdown">
                                                            <i class="fa" aria-hidden="true"></i>
                                                        </a>

                                                        @php
                                                            $all_user_name = \App\User::get();
                                                        @endphp

                                                        <div class="dropdown-menu filter-content shadow" role="menu">
                                                            <p>Filter Value</p>
                                                            <select class="form-control b-r-0" name="user_id" id="user_id" onchange='saveValue(this);'>
                                                                <option value="">Select Modifier</option>
                                                                @if(isset($all_user_name))
                                                                    @foreach($all_user_name as $user_name)
                                                                        <option value="{{$user_name->id}}">{{$user_name->name}}</option>
                                                                    @endforeach
                                                                @endif
                                                            </select>
                                                            <div class="checkbox checkbox-custom checkbox m-t-10 m-b-10">
                                                                <input id="opt-out5" type="checkbox" name="opt_out" value="1"><label for="opt-out5">Opt Out</label>
                                                            </div>
                                                            <!-- <input type="hidden" name="column_name" value="user_id">
                                                            <input type="hidden" name="route_name" value="available-quantity-change-log"> -->
                                                            <button type="submit" class="btn btn-primary filter-apply-btn float-right">Apply <i class="fa fa-arrow-circle-right ml-1"></i></button>
                                                        </div>

                                                </div>
                                                <div>Modifier</div>
                                            </div>
                                        </th>
                                        <th class="date text-center" style="width: 10%">
                                            <div class="d-flex justify-content-center">
                                                <div class="btn-group">

                                                        <a type="button" class="dropdown-toggle filter-btn" data-toggle="dropdown">
                                                            <i class="fa" aria-hidden="true"></i>
                                                        </a>
                                                        <div class="dropdown-menu filter-content shadow" role="menu">
                                                            <p>Filter Value</p>
                                                            <input type="text" class="form-control input-text" name="updated_at" id="updated_at" onchange='saveValue(this);' placeholder="D-M-Y or Y-M-D">
                                                            <div class="checkbox checkbox-custom checkbox m-t-10 m-b-10">
                                                                <input id="opt-out6" type="checkbox" name="opt_out" value="1"><label for="opt-out6">Opt Out</label>
                                                            </div>
                                                            <!-- <input type="hidden" name="column_name" value="updated_at">
                                                            <input type="hidden" name="route_name" value="available-quantity-change-log"> -->
                                                            <button type="submit" class="btn btn-primary filter-apply-btn float-right">Apply <i class="fa fa-arrow-circle-right ml-1"></i></button>
                                                        </div>

                                                </div>
                                                <div>Date</div>
                                            </div>
                                        </th>
                                        <!-- <th class="reason text-center" style="width: 10%">Reason</th> -->
                                    </tr>

                                    </thead>
                                    <!--End table head-->

                                    <!--start table body-->
                                    <tbody id="table-body">
                                    @isset($allChangeLog)
                                        @foreach($allChangeLog as $result)
                                            <tr>
                                                <td class="image text-center" style="width: 10%">
                                                    <img src="{{$result->variationInfo->image ?? $result->variationInfo->master_single_image->image_url}}" class="rounded-circle" style="width: 50px" alt="">
                                                </td>
                                                <td class="variation_id text-center" style="width: 10%">{{$result->variation_id}}</td>
                                                <td class="title" style="width: 20%">{{$result->variationInfo->product_draft->name ?? ''}}</td>
                                                <td class="sku" style="width: 10%">{{$result->variationInfo->sku ?? ''}}</td>
                                                <td class="previous_quantity text-center" style="width: 10%">{{$result->previous_quantity}}</td>
                                                <td class="updated_quantity text-center" style="width: 10%">{{$result->updated_quantity}}</td>
                                                <td class="modifier text-center" style="width: 10%">{{$result->userInfo->name}}</td>
                                                <td class="date text-center" style="width: 10%">{{date('d-m-Y H:i:s',strtotime($result->updated_at))}}</td>
                                                <!-- <td class="reason text-center" style="width: 10%">{!! $result->reason !!}</td> -->
                                            </tr>
                                        @endforeach
                                    @endisset
                                    </tbody>
                                    <!--End table body-->
                                </table>
                                </form>
                                <!--End table section-->

                                <!--table below pagination sec-->
                                <div class="row table-foo-sec">
                                    <div class="col-md-6 d-flex justify-content-md-start align-items-center"> </div>
                                    <div class="col-md-6">
                                        <div class="d-flex justify-content-md-end align-items-center py-2">
                                            <div class="pagination-area">
                                                <div class="datatable-pages d-flex align-items-center">
                                                    <span class="displaying-num">{{$allChangeLog->total()}} items</span>
                                                    <span class="pagination-links d-flex">
                                                    @if($allChangeLog->currentPage() > 1)
                                                    <a class="first-page btn {{$allChangeLog->currentPage() > 1 ? '' : 'disable'}}" href="{{$all_decode_available_quantity_change_log->first_page_url}}" data-toggle="tooltip" data-placement="top" title="First Page">
                                                        <span class="screen-reader-text d-none">First page</span>
                                                        <span aria-hidden="true">«</span>
                                                    </a>
                                                    <a class="prev-page btn {{$allChangeLog->currentPage() > 1 ? '' : 'disable'}}" href="{{$all_decode_available_quantity_change_log->prev_page_url}}" data-toggle="tooltip" data-placement="top" title="Previous Page">
                                                        <span class="screen-reader-text d-none">Previous page</span>
                                                        <span aria-hidden="true">‹</span>
                                                    </a>
                                                    @endif
                                                    <span class="screen-reader-text" style="display: none;">Current Page</span>
                                                    <span class="paging-input d-flex align-items-center">
                                                        <span class="datatable-paging-text d-flex pl-1"> {{$all_decode_available_quantity_change_log->current_page}} of <span class="total-pages"> {{$all_decode_available_quantity_change_log->last_page}} </span></span>
                                                    </span>
                                                    @if($allChangeLog->currentPage() !== $allChangeLog->lastPage())
                                                    <a class="next-page btn" href="{{$all_decode_available_quantity_change_log->next_page_url}}" data-toggle="tooltip" data-placement="top" title="Next Page">
                                                        <span class="screen-reader-text d-none">Next page</span>
                                                        <span aria-hidden="true">›</span>
                                                    </a>
                                                    <a class="last-page btn" href="{{$all_decode_available_quantity_change_log->last_page_url}}" data-toggle="tooltip" data-placement="top" title="Last Page">
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



                            </div>
                        </div>
                    </div>
                   <!--End Card box-->

            </div> <!-- container -->
        </div> <!-- content -->
    </div>  <!-- content page -->


    <script>
        $(document).ready(function(){
            if($('#is_search').val() == ''){
                localStorage.clear();
            }
            $("#in-row-shelf-wise-search").on("keyup", function() {
                let search_value = $(this).val().toLowerCase();
                if(search_value == ''){
                    return false;
                }
                console.log(search_value);
                $.ajax({
                    type: "post",
                    url: "{{url('shelf-qty-change-log-search')}}",
                    data: {
                        "_token": "{{csrf_token()}}",
                        "search_value": search_value
                    },
                    beforeSend: function(){
                        $('#ajax_loader').show();
                    },
                    success: function (response) {
                        console.log(response);
                        if(response.data != 'error'){
                            $('tbody').html(response.data);
                        }
                        $('span.search_result_show').addClass('text-success').html(response.total_row+' result found');
                        $('#ajax_loader').hide();
                    },
                    completle: function () {
                        $('#ajax_loader').hide();
                    }
                });

            });
        });

        //screen option toggle
        $(document).ready(function(){
            $(".screen-option-btn").click(function(){
                $(".screen-option-content").slideToggle(500);
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

        //prevent onclick dropdown menu close
        $('.filter-content').on('click', function(event){
            event.stopPropagation();
        });
        document.getElementById("variation_id").value = getSavedValue("variation_id");    // set the value to this input
        document.getElementById("title").value = getSavedValue("title");    // set the value to this input
        document.getElementById("sku").value = getSavedValue("updated_qskuuantity");    // set the value to this input
        document.getElementById("previous_quantity").value = getSavedValue("previous_quantity");    // set the value to this input
        document.getElementById("updated_quantity").value = getSavedValue("updated_quantity");    // set the value to this input
        document.getElementById("user_id").value = getSavedValue("user_id");    // set the value to this input
        document.getElementById("updated_at").value = getSavedValue("updated_at");    // set the value to this input
        /* Here you can add more inputs to set value. if it's saved */

        //Save the value function - save it to localStorage as (ID, VALUE)
        function saveValue(e){
            var id = e.id;  // get the sender's id to save it .
            var val = e.value; // get the value.
            localStorage.setItem(id, val);// Every time user writing something, the localStorage's value will override .
        }

        //get the saved value function - return the value of "v" from localStorage.
        function getSavedValue  (v){
            if (!localStorage.getItem(v)) {
                return "";// You can change this to your defualt value.
            }
            return localStorage.getItem(v);
        }
    </script>


@endsection
