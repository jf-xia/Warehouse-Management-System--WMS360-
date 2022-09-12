@extends('master')

@section('title')
    {{$page_title}}
@endsection

@section('content')

    <div class="content-page">
        <!-- Start content -->
        <div class="content">
            <div class="container-fluid">


                <!----ON OFF SWITCH ARRAY KEY DECLARATION---->
                <input type="hidden" id="firstKey" value="shelf">
                <input type="hidden" id="secondKey" value="reshelved_product">
                <!----END ON OFF SWITCH ARRAY KEY DECLARATION---->



                <!--screen option-->
                <div class="row">
                    <div class="col-md-12">
                        <div class="card-box screen-option-content" style="display: none">

                            <div class="d-flex justify-content-between">
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
                            <li class="breadcrumb-item"> Shelf </li>
                            <li class="breadcrumb-item active" aria-current="page"> Reshelved Product </li>
                        </ol>
                    </div>
                    <div class="screen-option-btn">
                        <button class="btn btn-link waves-effect waves-light" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                            Screen Options &nbsp; <i class="fa" aria-hidden="true"></i>
                        </button>
                        <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion"></div>
                    </div>
                </div>



                <div class="row m-t-20">
                    <div class="col-md-12">
                        <div class="card-box table-responsive shadow reshelved-product-card">


                            @if(Session::has('message'))
                                <div class="alert alert-danger">
                                    <button type="button" class="close" data-dismiss="alert">×</button>
                                    <strong>{!! Session::get('message') !!}</strong>
                                </div>
                            @endif

                            @if(Session::has('no_data_found'))
                                <div class="alert alert-danger" role="alert">
                                    <strong>{!! Session::get('no_data_found') !!}</strong>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif


                            <div class="d-flex justify-content-between product-inner p-b-10">
                                <div class="row-wise-search search-terms">
                                    <input class="form-control mb-1 ajax-order-search" id="in-row-shelf-wise-search" type="text" placeholder="Search by Shelf....">
                                </div>
                                <div class="pagination-area mt-xs-10 mb-xs-5">
                                    <form action="{{url('pagination-all')}}" method="post">
                                        @csrf
                                        <div class="datatable-pages d-flex align-items-center">
                                            <span class="displaying-num">{{$all_reshelved_product_list->total()}} items</span>
                                            <span class="pagination-links d-flex">
                                                @if($all_reshelved_product_list->currentPage() > 1)
                                                <a class="first-page btn {{$all_reshelved_product_list->currentPage() > 1 ? '' : 'disable'}}" href="{{$all_decode_reshelved_product->first_page_url}}" data-toggle="tooltip" data-placement="top" title="First Page">
                                                    <span class="screen-reader-text d-none">First page</span>
                                                    <span aria-hidden="true">«</span>
                                                </a>
                                                <a class="prev-page btn {{$all_reshelved_product_list->currentPage() > 1 ? '' : 'disable'}}" href="{{$all_decode_reshelved_product->prev_page_url}}" data-toggle="tooltip" data-placement="top" title="Previous Page">
                                                    <span class="screen-reader-text d-none">Previous page</span>
                                                    <span aria-hidden="true">‹</span>
                                                </a>
                                                @endif
                                                <span class="paging-input d-flex align-items-center">
                                                    <label for="current-page-selector" class="screen-reader-text d-none">Current Page</label>
                                                    <input class="current-page" id="current-page-selector" type="text" name="paged" value="{{$all_decode_reshelved_product->current_page}}" size="3" aria-describedby="table-paging">
                                                    <span class="datatable-paging-text d-flex"> of <span class="total-pages">{{$all_decode_reshelved_product->last_page}}</span></span>
                                                    <input type="hidden" name="route_name" value="reshelved-product-list">
                                                </span>
                                                @if($all_reshelved_product_list->currentPage() !== $all_reshelved_product_list->lastPage())
                                                <a class="next-page btn" href="{{$all_decode_reshelved_product->next_page_url}}" data-toggle="tooltip" data-placement="top" title="Next Page">
                                                    <span class="screen-reader-text d-none">Next page</span>
                                                    <span aria-hidden="true">›</span>
                                                </a>
                                                <a class="last-page btn" href="{{$all_decode_reshelved_product->last_page_url}}" data-toggle="tooltip" data-placement="top" title="Last Page">
                                                    <span class="screen-reader-text d-none">Last page</span>
                                                    <span aria-hidden="true">»</span>
                                                </a>
                                                @endif
                                            </span>
                                        </div>
                                    </form>
                                </div>
                            </div>

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
                            <table class="reshelved-product-table w-100">
                                <thead>
                                <form action="{{url('column-search')}}" method="post" id="reshelfListForm">
                                @csrf
                                <input type="hidden" name="route_name" value="reshelved-product-list">
                                <tr>
                                    <th>
                                        <div class="d-flex justify-content-center">
                                            <div class="btn-group">
                                                <a type="button" class="dropdown-toggle filter-btn" data-toggle="dropdown">
                                                    <i class="fa @isset($allCondition['shelf_id'])text-warning @endisset" aria-hidden="true"></i>
                                                </a>
                                                <div class="dropdown-menu filter-content shadow" role="menu">
                                                    <p>Filter Value</p>
                                                    <input type="text" class="form-control input-text" name="shelf_id" value="{{$allCondition['shelf_id'] ?? ''}}">
                                                    <div class="checkbox checkbox-custom checkbox m-t-10 m-b-10">
                                                        <input id="opt-out1" type="checkbox" name="shelf_opt_out" value="1" @isset($allCondition['shelf_opt_out']) checked @endisset><label for="opt-out1">Opt Out</label>
                                                    </div>
                                                    @if(isset($allCondition['shelf_id']))
                                                        <div class="individual_clr">
                                                            <button title="Clear filters" type="button" class='btn btn-outline-info clear-params'><i class="fas fa-times"></i></button>
                                                        </div>
                                                    @endif
                                                    <button type="submit" class="btn btn-primary filter-apply-btn float-right">Apply <i class="fa fa-arrow-circle-right ml-1"></i></button>
                                                </div>
                                            </div>
                                            <div>Shelf</div>
                                        </div>
                                    </th>
                                    <th class="text-center">
                                        <div class="d-flex justify-content-center">
                                            <div class="btn-group">
                                                <a type="button" class="dropdown-toggle filter-btn" data-toggle="dropdown">
                                                    <i class="fa @isset($allCondition['variation_id'])text-warning @endisset" aria-hidden="true"></i>
                                                </a>
                                                <div class="dropdown-menu filter-content shadow" role="menu">
                                                    <p>Filter Value</p>
                                                    <input type="text" class="form-control input-text" name="variation_id" value="{{$allCondition['variation_id'] ?? ''}}">
                                                    <div class="checkbox checkbox-custom checkbox m-t-10 m-b-10">
                                                        <input id="opt-out2" type="checkbox" name="variation_id_opt_out" value="1" @isset($allCondition['variation_id_opt_out']) checked @endisset><label for="opt-out2">Opt Out</label>
                                                    </div>
                                                    @if(isset($allCondition['variation_id']))
                                                        <div class="individual_clr">
                                                            <button title="Clear filters" type="button" class='btn btn-outline-info clear-params'><i class="fas fa-times"></i></button>
                                                        </div>
                                                    @endif
                                                    <button type="submit" class="btn btn-primary filter-apply-btn float-right">Apply <i class="fa fa-arrow-circle-right ml-1"></i></button>
                                                </div>
                                            </div>
                                            <div>SKU</div>
                                        </div>
                                    </th>
                                    <th class="text-center filter-symbol">
                                        <div class="d-flex justify-content-center">
                                            <div class="btn-group">
                                                <a type="button" class="dropdown-toggle filter-btn" data-toggle="dropdown">
                                                    <i class="fa @isset($allCondition['shelved_quantity'])text-warning @endisset" aria-hidden="true"></i>
                                                </a>
                                                <div class="dropdown-menu filter-content stock-filter-content shadow" role="menu">
                                                    <p>Filter Value</p>
                                                    <div class="d-flex">
                                                        <div>
                                                            <select class="form-control" name="shelved_quantity_opt">
                                                                <option value=""></option>
                                                                <option value="=" @if(isset($allCondition['shelved_quantity_opt']) && ($allCondition['shelved_quantity_opt'] == '=')) selected @endif>=</option>
                                                                <option value="<" @if(isset($allCondition['shelved_quantity_opt']) && ($allCondition['shelved_quantity_opt'] == '<')) selected @endif><</option>
                                                                <option value=">" @if(isset($allCondition['shelved_quantity_opt']) && ($allCondition['shelved_quantity_opt'] == '>')) selected @endif>></option>
                                                                <option value="<=" @if(isset($allCondition['shelved_quantity_opt']) && ($allCondition['shelved_quantity_opt'] == '≤')) selected @endif>≤</option>
                                                                <option value=">=" @if(isset($allCondition['shelved_quantity_opt']) && ($allCondition['shelved_quantity_opt'] == '≥')) selected @endif>≥</option>
                                                            </select>
                                                        </div>
                                                        <div class="ml-2">
                                                            <input type="number" class="form-control input-text symbol-filter-input-text" name="shelved_quantity" value="{{$allCondition['shelved_quantity'] ?? ''}}">
                                                        </div>
                                                    </div>
                                                    <div class="checkbox checkbox-custom checkbox m-t-10 m-b-10">
                                                        <input id="opt-out3" type="checkbox" name="shelved_quantity_opt_out" value="1" @isset($allCondition['shelved_quantity_opt_out']) checked @endisset><label for="opt-out3">Opt Out</label>
                                                    </div>
                                                    @if(isset($allCondition['shelved_quantity']))
                                                        <div class="individual_clr">
                                                            <button title="Clear filters" type="button" class='btn btn-outline-info clear-params'><i class="fas fa-times"></i></button>
                                                        </div>
                                                    @endif
                                                    <button type="submit" class="btn btn-primary filter-apply-btn float-right">Apply<i class="fa fa-arrow-circle-right ml-1"></i></button>
                                                </div>
                                            </div>
                                            <div>Reshelved Quantity</div>
                                        </div>
                                    </th>
                                    <th class="text-center">
                                        <div class="d-flex justify-content-center">
                                            <div class="btn-group">
                                                <a type="button" class="dropdown-toggle filter-btn" data-toggle="dropdown">
                                                    <i class="fa @isset($allCondition['user_id'])text-warning @endisset" aria-hidden="true"></i>
                                                </a>
                                                @php
                                                    $all_user_name = \App\User::get();
                                                @endphp
                                                <div class="dropdown-menu filter-content shadow" role="menu">
                                                    <p>Filter Value</p>
                                                    <select class="form-control b-r-0" name="user_id">
                                                        @if(isset($all_user_name))
                                                            @if($all_user_name->count() == 1)
                                                                @foreach($all_user_name as $user_name)
                                                                    <option value="{{$user_name->id}}" selected="selected">{{$user_name->name}}</option>
                                                                @endforeach
                                                            @else
                                                                <option value="">Select Reshelver</option>
                                                                @foreach($all_user_name as $user_name)
                                                                    @if(isset($allCondition['user_id']) && ($allCondition['user_id'] == $user_name->id))
                                                                        <option value="{{$user_name->id}}" selected>{{$user_name->name}}</option>
                                                                    @else
                                                                        <option value="{{$user_name->id}}">{{$user_name->name}}</option>
                                                                    @endif
                                                                 @endforeach
                                                            @endif
                                                        @endif
                                                    </select>
                                                    <div class="checkbox checkbox-custom checkbox m-t-10 m-b-10">
                                                        <input id="opt-out4" type="checkbox" name="user_id_opt_out" value="1" @isset($allCondition['user_id_opt_out']) checked @endisset><label for="opt-out4">Opt Out</label>
                                                    </div>
                                                    @if(isset($allCondition['user_id']))
                                                        <div class="individual_clr">
                                                            <button title="Clear filters" type="button" class='btn btn-outline-info clear-params'><i class="fas fa-times"></i></button>
                                                        </div>
                                                    @endif
                                                    <button type="submit" class="btn btn-primary filter-apply-btn float-right">Apply <i class="fa fa-arrow-circle-right ml-1"></i></button>
                                                </div>
                                            </div>
                                            <div>Reshelved By</div>
                                        </div>
                                    </th>
                                    <th class="text-center">
                                    <div class="d-flex justify-content-center">
                                            <div class="btn-group">
                                                <a type="button" class="dropdown-toggle filter-btn" data-toggle="dropdown">
                                                    <i class="fa @isset($allCondition['status'])text-warning @endisset" aria-hidden="true"></i>
                                                </a>
                                                <div class="dropdown-menu filter-content shadow" role="menu">
                                                    <p>Filter Value</p>
                                                    <select class="form-control b-r-0" name="status">
                                                        <option value="">Select Status</option>
                                                        <option value="1" @if(isset($allCondition['status']) && $allCondition['status'] == '1') selected @endif>Shelved</option>
                                                        <option value="0" @if(isset($allCondition['status']) && $allCondition['status'] == '0') selected @endif>Not Shelved</option>
                                                    </select>
                                                    <div class="checkbox checkbox-custom checkbox m-t-10 m-b-10">
                                                        <input id="opt-out5" type="checkbox" name="status_opt_out" value="1" @isset($allCondition['status_opt_out']) checked @endisset><label for="opt-out5">Opt Out</label>
                                                    </div>
                                                    @if(isset($allCondition['status']))
                                                        <div class="individual_clr">
                                                            <button title="Clear filters" type="button" class='btn btn-outline-info clear-params'><i class="fas fa-times"></i></button>
                                                        </div>
                                                    @endif
                                                    <button type="submit" class="btn btn-primary filter-apply-btn float-right">Apply <i class="fa fa-arrow-circle-right ml-1"></i></button>
                                                </div>
                                            </div>
                                            <div>
                                            <div class="d-flex justify-content-center align-items-center">
                                                <div>Status</div> &nbsp; &nbsp;
                                                    @if(count($allCondition) > 0)
                                                        <div><a title="Clear filters" href="{{asset('reshelved-product-list')}}" class='btn btn-outline-info'><img src="{{asset('assets/common-assets/25.png')}}"></a></div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </th>
                                </tr>
                                </form>
                                </thead>

                                <tbody id="table-body">
                                @isset($all_reshelved_product_list)
                                    @foreach($all_reshelved_product_list as $reshelved_product)
                                        <tr>
                                            <td class="text-center">
                                                <div class="id_tooltip_container d-flex justify-content-center align-items-center">
                                                    <span title="Click to Copy" onclick="textCopiedID(this);" class="id_copy_button">{{$reshelved_product->shelf_info->shelf_name ?? ''}}</span>
                                                    <span class="wms__id__tooltip__message" id="wms__id__tooltip__message">Copied!</span>
                                                </div>
                                                {{--loader added --}}
                                                <div id="product_variation_loading" class="variation_load" style="display: none;"></div>
                                            </td>
                                            <td class="text-center">{{$reshelved_product->variation_info->sku ?? null}}</td>
                                            <td class="text-center">{{$reshelved_product->quantity}}</td>
                                            <td class="text-center">{{$reshelved_product->user_info->name ?? ''}}</td>
                                            @if($reshelved_product->status == 1)
                                                <td class="text-center"><span class="label label-table label-success label-status">Shelved</span></td>
                                            @else
                                                <td class="text-center"><span class="label label-table label-danger label-status">Not Shelved</span></td>
                                            @endif

                                        </tr>
                                    @endforeach
                                @endisset
                                </tbody>
                            </table>

                            <!--table below pagination sec-->
                            <div class="row table-foo-sec">
                                <div class="col-md-6 d-flex justify-content-md-start align-items-center"> </div>
                                <div class="col-md-6">
                                    <div class="d-flex justify-content-md-end align-items-center py-2">
                                        {{--                                        {{$product_drafts->links()}}--}}
                                        <div class="pagination-area">
                                            <div class="datatable-pages d-flex align-items-center">
                                                <span class="displaying-num">{{$all_reshelved_product_list->total()}} items</span>
                                                <span class="pagination-links d-flex">
                                                    @if($all_reshelved_product_list->currentPage() > 1)
                                                    <a class="first-page btn {{$all_reshelved_product_list->currentPage() > 1 ? '' : 'disable'}}" href="{{$all_decode_reshelved_product->first_page_url}}" data-toggle="tooltip" data-placement="top" title="First Page">
                                                        <span class="screen-reader-text d-none">First page</span>
                                                        <span aria-hidden="true">«</span>
                                                    </a>
                                                    <a class="prev-page btn {{$all_reshelved_product_list->currentPage() > 1 ? '' : 'disable'}}" href="{{$all_decode_reshelved_product->prev_page_url}}" data-toggle="tooltip" data-placement="top" title="Previous Page">
                                                        <span class="screen-reader-text d-none">Previous page</span>
                                                        <span aria-hidden="true">‹</span>
                                                    </a>
                                                    @endif
                                                    <span class="screen-reader-text" style="display: none;">Current Page</span>
                                                    <span class="paging-input d-flex align-items-center">
                                                        <span class="datatable-paging-text d-flex pl-1"> {{$all_decode_reshelved_product->current_page}} of <span class="total-pages"> {{$all_decode_reshelved_product->last_page}} </span></span>
                                                    </span>
                                                    @if($all_reshelved_product_list->currentPage() !== $all_reshelved_product_list->lastPage())
                                                    <a class="next-page btn" href="{{$all_decode_reshelved_product->next_page_url}}" data-toggle="tooltip" data-placement="top" title="Next Page">
                                                        <span class="screen-reader-text d-none">Next page</span>
                                                        <span aria-hidden="true">›</span>
                                                    </a>
                                                    <a class="last-page btn" href="{{$all_decode_reshelved_product->last_page_url}}" data-toggle="tooltip" data-placement="top" title="Last Page">
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
                </div> <!-- end row -->

            </div> <!-- container -->
        </div> <!-- content -->
    </div>



    <script>


        $(document).ready(function(){
            $("#in-row-shelf-wise-search").on("keyup", function() {
                let search_value = $(this).val();
                if(search_value == ''){
                    return false;
                }
                console.log(search_value);
                $.ajax({
                    type: "post",
                    url: "{{url('reshelved-product-search')}}",
                    data: {
                        "_token": "{{csrf_token()}}",
                        "search_value": search_value
                    },
                    beforeSend: function(){
                        $("#ajax_loader").show()
                    },
                    success: function (response) {
                        console.log(response);
                        if(response.data != 'error'){
                            $('tbody').html(response.data);
                        }
                        $('span.search_result_show').addClass('text-success').html(response.total_row+' result found');
                        $("#ajax_loader").hide()
                    },
                    completle: function () {
                        $("#ajax_loader").hide()
                    }
                });

            });

            $('.individual_clr .clear-params').click(function(){
                console.log('found')
                $(this).closest('.filter-content').each(function(){
                    $(this).find('input,select').val('')
                    $(this).find('input').prop('checked',false)
                    $('#reshelfListForm').submit()
                })
            })
        });




        //Datatable row-wise searchable option
        // $(document).ready(function(){
        //     $("#row-wise-search").on("keyup", function() {
        //         let value = $(this).val().toLowerCase();
        //         $("#table-body tr").filter(function() {
        //             $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        //         });
        //
        //     });
        // });


        //screen option toggle
        $(document).ready(function(){
            $(".screen-option-btn").click(function(){
                $(".screen-option-content").slideToggle(500);
            });
        });

        //prevent onclick dropdown menu close
        $('.filter-content').on('click', function(event){
            event.stopPropagation();
        });



    </script>



@endsection
