
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

                            <!---------------------------ON OFF SWITCH BUTTON AREA------------------------>
                            <!--------------------------------------------------------------------------->

                            <div class="d-flex justify-content-between content-inner mt-2 mb-2">
                                <div class="d-block">
                                    <div class="d-flex align-items-center">
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="Shelf_name" class="onoffswitch-checkbox" id="Shelf_name" tabindex="0" @if(isset($setting['shelf']['shelf_quantity_change_log']['Shelf_name']) && $setting['shelf']['shelf_quantity_change_log']['Shelf_name'] == 1) checked @elseif(isset($setting['shelf']['shelf_quantity_change_log']['Shelf_name']) && $setting['shelf']['shelf_quantity_change_log']['Shelf_name'] == 0) @else checked @endif>
                                            <label class="onoffswitch-label" for="Shelf_name">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                        <div class="ml-1"><p>Shelf</p></div>
                                    </div>
                                    <div class="d-flex align-items-center mt-2">
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="previous_quantity" class="onoffswitch-checkbox" id="previous_quantity" tabindex="0" @if(isset($setting['shelf']['shelf_quantity_change_log']['previous_quantity']) && $setting['shelf']['shelf_quantity_change_log']['previous_quantity'] == 1) checked @elseif(isset($setting['shelf']['shelf_quantity_change_log']['previous_quantity']) && $setting['shelf']['shelf_quantity_change_log']['previous_quantity'] == 0) @else checked @endif>
                                            <label class="onoffswitch-label" for="previous_quantity">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                        <div class="ml-1"><p>Previous Quantity</p></div>
                                    </div>
                                </div>
                                <div class="d-block">
                                    <div class="d-flex align-items-center mt-sm-10">
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="updated_quantity" class="onoffswitch-checkbox" id="updated_quantity" tabindex="0" @if(isset($setting['shelf']['shelf_quantity_change_log']['updated_quantity']) && $setting['shelf']['shelf_quantity_change_log']['updated_quantity'] == 1) checked @elseif(isset($setting['shelf']['shelf_quantity_change_log']['updated_quantity']) && $setting['shelf']['shelf_quantity_change_log']['updated_quantity'] == 0) @else checked @endif>
                                            <label class="onoffswitch-label" for="updated_quantity">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                        <div class="ml-1"><p>Updated Quantity</p></div>
                                    </div>
                                    <div class="d-flex align-items-center mt-2">
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="title" class="onoffswitch-checkbox" id="title" tabindex="0" @if(isset($setting['shelf']['shelf_quantity_change_log']['title']) && $setting['shelf']['shelf_quantity_change_log']['title'] == 1) checked @elseif(isset($setting['shelf']['shelf_quantity_change_log']['title']) && $setting['shelf']['shelf_quantity_change_log']['title'] == 0) @else checked @endif>
                                            <label class="onoffswitch-label" for="title">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                        <div class="ml-1"><p>Title</p></div>
                                    </div>
                                </div>
                                <div class="d-block">
                                    <div class="d-flex align-items-center mt-xs-10">
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="modifier" class="onoffswitch-checkbox" id="modifier" tabindex="0" @if(isset($setting['shelf']['shelf_quantity_change_log']['modifier']) && $setting['shelf']['shelf_quantity_change_log']['modifier'] == 1) checked @elseif(isset($setting['shelf']['shelf_quantity_change_log']['modifier']) && $setting['shelf']['shelf_quantity_change_log']['modifier'] == 0) @else checked @endif>
                                            <label class="onoffswitch-label" for="modifier">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                        <div class="ml-1"><p>Modifier</p></div>
                                    </div>
                                    <div class="d-flex align-items-center mt-2">
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="reason" class="onoffswitch-checkbox" id="reason" tabindex="0" @if(isset($setting['shelf']['shelf_quantity_change_log']['reason']) && $setting['shelf']['shelf_quantity_change_log']['reason'] == 1) checked @elseif(isset($setting['shelf']['shelf_quantity_change_log']['reason']) && $setting['shelf']['shelf_quantity_change_log']['reason'] == 0) @else checked @endif>
                                            <label class="onoffswitch-label" for="reason">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                        <div class="ml-1"><p>Reason</p></div>
                                    </div>
                                </div>
                                <div class="d-block">
                                    <div class="d-flex align-items-center shelf-change-log">
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="date" class="onoffswitch-checkbox" id="date" tabindex="0" @if(isset($setting['shelf']['shelf_quantity_change_log']['date']) && $setting['shelf']['shelf_quantity_change_log']['date'] == 1) checked @elseif(isset($setting['shelf']['shelf_quantity_change_log']['date']) && $setting['shelf']['shelf_quantity_change_log']['date'] == 0) @else checked @endif>
                                            <label class="onoffswitch-label" for="date">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                        <div class="ml-1"><p>Date</p></div>
                                    </div>
                                </div>
                            </div>
                            <!---------------------------END ON OFF SWITCH BUTTON AREA------------------------>
                            <!--------------------------------------------------------------------------->

                            <!----ON OFF SWITCH ARRAY KEY DECLARATION---->
                            <input type="hidden" id="firstKey" value="shelf">
                            <input type="hidden" id="secondKey" value="shelf_quantity_change_log">
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
                            <li class="breadcrumb-item"> Inventory </li> 
                            <li class="breadcrumb-item active" aria-current="page"> Shelf Quantity Change Log </li>
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
                            <div class="card-box table-responsive shadow shelf-quantity-change-log-card">

                                <!--Start Backend error handler-->
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

                               <!--End Backend error handler-->


                                <!--start table upper side content-->
                                <div class="d-flex justify-content-between product-inner p-b-10">
                                    <div class="row-wise-search search-terms">
                                        <input class="form-control mb-1 ajax-order-search" id="in-row-shelf-wise-search" type="text" placeholder="Search....">
                                    </div>
                                    <!--start pagination-->
                                    <div class="pagination-area mt-xs-10 mb-xs-5">
                                        <form action="{{url('pagination-all')}}" method="post">
                                            @csrf
                                            <div class="datatable-pages d-flex align-items-center">
                                                <span class="displaying-num">{{$query_result->total()}} items</span>
                                                <span class="pagination-links d-flex">
                                                @if($query_result->currentPage() > 1)
                                                <a class="first-page btn {{$query_result->currentPage() > 1 ? '' : 'disable'}}" href="{{$all_decode_ShelfQuantityChangeLog_product->first_page_url}}" data-toggle="tooltip" data-placement="top" title="First Page">
                                                    <span class="screen-reader-text d-none">First page</span>
                                                    <span aria-hidden="true">«</span>
                                                </a>
                                                <a class="prev-page btn {{$query_result->currentPage() > 1 ? '' : 'disable'}}" href="{{$all_decode_ShelfQuantityChangeLog_product->prev_page_url}}" data-toggle="tooltip" data-placement="top" title="Previous Page">
                                                    <span class="screen-reader-text d-none">Previous page</span>
                                                    <span aria-hidden="true">‹</span>
                                                </a>
                                                @endif
                                                <span class="paging-input d-flex align-items-center">
                                                    <label for="current-page-selector" class="screen-reader-text d-none">Current Page</label>
                                                    <input class="current-page" id="current-page-selector" type="text" name="paged" value="{{$all_decode_ShelfQuantityChangeLog_product->current_page}}" size="3" aria-describedby="table-paging">
                                                    <span class="datatable-paging-text d-flex"> of <span class="total-pages">{{$all_decode_ShelfQuantityChangeLog_product->last_page}}</span></span>
                                                    <input type="hidden" name="route_name" value="change-shelf-quantity-log">
                                                </span>
                                                @if($query_result->currentPage() !== $query_result->lastPage())
                                                <a class="next-page btn" href="{{$all_decode_ShelfQuantityChangeLog_product->next_page_url}}" data-toggle="tooltip" data-placement="top" title="Next Page">
                                                    <span class="screen-reader-text d-none">Next page</span>
                                                    <span aria-hidden="true">›</span>
                                                </a>
                                                <a class="last-page btn" href="{{$all_decode_ShelfQuantityChangeLog_product->last_page_url}}" data-toggle="tooltip" data-placement="top" title="Last Page">
                                                    <span class="screen-reader-text d-none">Last page</span>
                                                    <span aria-hidden="true">»</span>
                                                </a>
                                                @endif
                                            </span>
                                            </div>
                                        </form>
                                    </div>
                                    <!--End pagination-->
                                </div>
                                <!--End table upper side content-->


                                <!--start loader-->
                                {{-- <div id="Load" class="load" style="display: none;">
                                    <div class="load__container">
                                        <div class="load__animation"></div>
                                        <div class="load__mask"></div>
                                        <span class="load__title">Content is loading...</span>
                                    </div>
                                </div> --}}
                                <!--End loader-->

                                <span class="search_result_show"></span> <!--message show-->

                                <!--start table section-->
                                <table class="shelf-quantity-change-log-table w-100">
                                    <!--start table head-->
                                    <thead>
                                    <tr>
                                        <th class="Shelf_name text-center" style="width: 10%">
                                            <div class="d-flex justify-content-center">
                                                <div class="btn-group">
                                                    <form action="{{url('column-search')}}" method="post">
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
                                                            <input type="hidden" name="column_name" value="shelf_id">
                                                            <input type="hidden" name="route_name" value="change-shelf-quantity-log">
                                                            <button type="submit" class="btn btn-primary filter-apply-btn float-right">Apply <i class="fa fa-arrow-circle-right ml-1"></i></button>
                                                        </div>
                                                    </form>
                                                </div>
                                                <div>Shelf</div>
                                            </div>
                                        </th>
                                        <th class="previous_quantity filter-symbol text-center" style="width: 15%">
                                            <div class="d-flex justify-content-center">
                                                <div class="btn-group">
                                                    <form action="{{url('column-search')}}" method="post">
                                                        @csrf
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
                                                                    <input type="number" class="form-control input-text symbol-filter-input-text" name="search_value">
                                                                </div>
                                                            </div>
                                                            <div class="checkbox checkbox-custom checkbox m-t-10 m-b-10">
                                                                <input id="opt-out2" type="checkbox" name="opt_out" value="1"><label for="opt-out2">Opt Out</label>
                                                            </div>
                                                            <input type="hidden" name="column_name" value="previous_quantity">
                                                            <input type="hidden" name="route_name" value="change-shelf-quantity-log">
                                                            <button type="submit" class="btn btn-primary filter-apply-btn float-right">Apply<i class="fa fa-arrow-circle-right ml-1"></i></button>
                                                        </div>
                                                    </form>
                                                </div>
                                                <div>Previous Quantity</div>
                                            </div>
                                        </th>
                                        <th class="updated_quantity filter-symbol text-center" style="width: 15%">
                                            <div class="d-flex justify-content-center">
                                                <div class="btn-group">
                                                    <form action="{{url('column-search')}}" method="post">
                                                        @csrf
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
                                                                    <input type="number" class="form-control input-text symbol-filter-input-text" name="search_value">
                                                                </div>
                                                            </div>
                                                            <div class="checkbox checkbox-custom checkbox m-t-10 m-b-10">
                                                                <input id="opt-out3" type="checkbox" name="opt_out" value="1"><label for="opt-out3">Opt Out</label>
                                                            </div>
                                                            <input type="hidden" name="column_name" value="update_quantity">
                                                            <input type="hidden" name="route_name" value="change-shelf-quantity-log">
                                                            <button type="submit" class="btn btn-primary filter-apply-btn float-right">Apply<i class="fa fa-arrow-circle-right ml-1"></i></button>
                                                        </div>
                                                    </form>
                                                </div>
                                                <div>Updated Quantity</div>
                                            </div>
                                        </th>
                                        <th class="title filter-symbol" style="width: 30%">
                                            <div class="d-flex justify-content-start">
                                                <div class="btn-group">
                                                    <form action="{{url('column-search')}}" method="post">
                                                        @csrf
                                                        <a type="button" class="dropdown-toggle filter-btn" data-toggle="dropdown">
                                                            <i class="fa" aria-hidden="true"></i>
                                                        </a>
                                                        <div class="dropdown-menu filter-content shadow" role="menu">
                                                            <p>Filter Value</p>
                                                            <input type="text" class="form-control input-text" name="search_value">
                                                            <div class="checkbox checkbox-custom checkbox m-t-10 m-b-10">
                                                                <input id="opt-out4" type="checkbox" name="opt_out" value="1"><label for="opt-out4">Opt Out</label>
                                                            </div>
                                                            <input type="hidden" name="column_name" value="variation_id">
                                                            <input type="hidden" name="route_name" value="change-shelf-quantity-log">
                                                            <button type="submit" class="btn btn-primary filter-apply-btn float-right">Apply <i class="fa fa-arrow-circle-right ml-1"></i></button>
                                                        </div>
                                                    </form>
                                                </div>
                                                <div>Title</div>
                                            </div>
                                        </th>
                                        <th class="modifier text-center">
                                            <div class="d-flex justify-content-center">
                                                <div class="btn-group">
                                                    <form action="{{url('column-search')}}" method="post">
                                                        @csrf
                                                        <a type="button" class="dropdown-toggle filter-btn" data-toggle="dropdown">
                                                            <i class="fa" aria-hidden="true"></i>
                                                        </a>

                                                        @php
                                                            $all_user_name = \App\User::get();
                                                        @endphp

                                                        <div class="dropdown-menu filter-content shadow" role="menu">
                                                            <p>Filter Value</p>
                                                            <select class="form-control b-r-0" name="search_value">

                                                                @if(isset($all_user_name))
                                                                    @if($all_user_name->count() == 1)
                                                                        @foreach($all_user_name as $user_name)
                                                                            <option value="{{$user_name->id}}" selected="selected">{{$user_name->name}}</option>
                                                                        @endforeach
                                                                    @else
                                                                        <option hidden>Select Modifier</option>
                                                                        @foreach($all_user_name as $user_name)
                                                                            <option value="{{$user_name->id}}">{{$user_name->name}}</option>
                                                                        @endforeach
                                                                    @endif
                                                                @endif
                                                            </select>
                                                            <div class="checkbox checkbox-custom checkbox m-t-10 m-b-10">
                                                                <input id="opt-out5" type="checkbox" name="opt_out" value="1"><label for="opt-out5">Opt Out</label>
                                                            </div>
                                                            <input type="hidden" name="column_name" value="user_id">
                                                            <input type="hidden" name="route_name" value="change-shelf-quantity-log">
                                                            <button type="submit" class="btn btn-primary filter-apply-btn float-right">Apply <i class="fa fa-arrow-circle-right ml-1"></i></button>
                                                        </div>
                                                    </form>
                                                </div>
                                                <div>Modifier</div>
                                            </div>
                                        </th>
                                        <th class="date text-center">
                                            <div class="d-flex justify-content-center">
                                                <div class="btn-group">
                                                    <form action="{{url('column-search')}}" method="post">
                                                        @csrf
                                                        <a type="button" class="dropdown-toggle filter-btn" data-toggle="dropdown">
                                                            <i class="fa" aria-hidden="true"></i>
                                                        </a>
                                                        <div class="dropdown-menu filter-content shadow" role="menu">
                                                            <p>Filter Value</p>
                                                            <input type="text" class="form-control input-text" name="search_value" placeholder="D-M-Y or Y-M-D">
                                                            <div class="checkbox checkbox-custom checkbox m-t-10 m-b-10">
                                                                <input id="opt-out6" type="checkbox" name="opt_out" value="1"><label for="opt-out6">Opt Out</label>
                                                            </div>
                                                            <input type="hidden" name="column_name" value="updated_at">
                                                            <input type="hidden" name="route_name" value="change-shelf-quantity-log">
                                                            <button type="submit" class="btn btn-primary filter-apply-btn float-right">Apply <i class="fa fa-arrow-circle-right ml-1"></i></button>
                                                        </div>
                                                    </form>
                                                </div>
                                                <div>Date</div>
                                            </div>
                                        </th>
                                        <th class="reason text-center">Reason</th>
                                        <th style="width: 8%">Actions</th>
                                    </tr>
                                    </thead>
                                    <!--End table head-->

                                    <!--start table body-->
                                    <tbody id="table-body">
                                    @isset($query_result)
                                        @foreach($query_result as $result)
                                            <tr>
                                                <td class="Shelf_name text-center" style="width: 10%">
                                                    <div class="id_tooltip_container d-flex justify-content-center align-items-center">
                                                        <span title="Click to Copy" onclick="textCopiedID(this);" class="id_copy_button">{{$result->shelf_info->shelf_name ?? ''}}</span>
                                                        <span class="wms__id__tooltip__message" id="wms__id__tooltip__message">Copied!</span>
                                                    </div>
                                                    {{--loader added --}}
                                                    <div id="product_variation_loading" class="variation_load" style="display: none;"></div>
                                                </td>
                                                <td class="previous_quantity text-center" style="width: 15%">{{$result->previous_quantity}}</td>
                                                <td class="updated_quantity text-center" style="width: 15%">{{$result->update_quantity}}</td>
                                                <td class="title" style="width: 30%">{{$result->variation_info->product_draft->name ?? ''}}</td>
                                                <td class="modifier text-center">{{$result->user_info->name ?? ''}}</td>
                                                <td class="date text-center">{{date('d-m-Y H:i:s',strtotime($result->updated_at))}}</td>
                                                <td class="reason text-center">{!! $result->reason !!}</td>
                                                <td class="actions" style="width: 8%">
                                                    <div class="d-flex justify-content-start">
                                                        <div class="align-items-center mr-2">
                                                            <a class="btn-size del-pub delete-btn" style="cursor: pointer" href="{{url('delete-change-shelf-quantity-log/'.$result->id)}}" data-toggle="tooltip" data-placement="top" title="Delete" onclick="return check_delete('log');"><i class="fa fa-trash" aria-hidden="true"></i></a>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endisset
                                    </tbody>
                                    <!--End table body-->
                                </table>
                                <!--End table section-->

                                <!--table below pagination sec-->
                                <div class="row table-foo-sec">
                                    <div class="col-md-6 d-flex justify-content-md-start align-items-center"> </div>
                                    <div class="col-md-6">
                                        <div class="d-flex justify-content-md-end align-items-center py-2">
                                            <div class="pagination-area">
                                                <div class="datatable-pages d-flex align-items-center">
                                                    <span class="displaying-num">{{$query_result->total()}} items</span>
                                                    <span class="pagination-links d-flex">
                                                    @if($query_result->currentPage() > 1)
                                                    <a class="first-page btn {{$query_result->currentPage() > 1 ? '' : 'disable'}}" href="{{$all_decode_ShelfQuantityChangeLog_product->first_page_url}}" data-toggle="tooltip" data-placement="top" title="First Page">
                                                        <span class="screen-reader-text d-none">First page</span>
                                                        <span aria-hidden="true">«</span>
                                                    </a>
                                                    <a class="prev-page btn {{$query_result->currentPage() > 1 ? '' : 'disable'}}" href="{{$all_decode_ShelfQuantityChangeLog_product->prev_page_url}}" data-toggle="tooltip" data-placement="top" title="Previous Page">
                                                        <span class="screen-reader-text d-none">Previous page</span>
                                                        <span aria-hidden="true">‹</span>
                                                    </a>
                                                    @endif
                                                    <span class="screen-reader-text" style="display: none;">Current Page</span>
                                                    <span class="paging-input d-flex align-items-center">
                                                        <span class="datatable-paging-text d-flex pl-1"> {{$all_decode_ShelfQuantityChangeLog_product->current_page}} of <span class="total-pages"> {{$all_decode_ShelfQuantityChangeLog_product->last_page}} </span></span>
                                                    </span>
                                                    @if($query_result->currentPage() !== $query_result->lastPage())
                                                    <a class="next-page btn" href="{{$all_decode_ShelfQuantityChangeLog_product->next_page_url}}" data-toggle="tooltip" data-placement="top" title="Next Page">
                                                        <span class="screen-reader-text d-none">Next page</span>
                                                        <span aria-hidden="true">›</span>
                                                    </a>
                                                    <a class="last-page btn" href="{{$all_decode_ShelfQuantityChangeLog_product->last_page_url}}" data-toggle="tooltip" data-placement="top" title="Last Page">
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
        // $("#display-all").click(function(){
        //     $("table tr th, table tr td").show();
        //     $(".column-display .checkbox input[type=checkbox]").prop("checked", "true");
        // });


        // After unchecked any column display all checkbox will be unchecked
        // $(".column-display .checkbox input[type=checkbox]").change(function(){
        //     if (!$(this).prop("checked")){
        //         $("#display-all").prop("checked",false);
        //     }
        // });

        //prevent onclick dropdown menu close
        $('.filter-content').on('click', function(event){
            event.stopPropagation();
        });

    </script>


@endsection
