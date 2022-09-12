@extends('master')

@section('title')
    Shelf | WMS360
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


                <!----ON OFF SWITCH ARRAY KEY DECLARATION---->
                <input type="hidden" id="firstKey" value="shelf">
                <input type="hidden" id="secondKey" value="shelf_list">
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
                                <div>
                                    <a href="#addShelf" data-animation="slit" data-plugin="custommodal" data-overlaySpeed="100" data-overlayColor="#36404a"><button class="btn btn-default">Add Shelf</button></a>&nbsp;
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
                            <li class="breadcrumb-item active" aria-current="page">Shelf</li>
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
                        <div class="card-box table-responsive shadow shelf-card">

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

                            @if (Session::has('shelf_add_success_msg'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    {!! Session::get('shelf_add_success_msg') !!}
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif

                            @if (Session::has('shelf_updated_success_msg'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    {!! Session::get('shelf_updated_success_msg') !!}
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif

                            @if (Session::has('shelf_delete_success_msg'))
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    {!! Session::get('shelf_delete_success_msg') !!}
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif


                            <div class="d-flex justify-content-between product-inner p-b-10">


                                <div class="row-wise-search search-terms">
                                    <input class="form-control mb-1 ajax-order-search" id="in-row-id-name-wise-search" type="text" placeholder="Search by ID, Name....">
                                </div>


                                <div class="pagination-area mt-xs-10 mb-xs-5">
                                    <form action="{{url('pagination-all')}}" method="post">
                                        @csrf
                                        <div class="datatable-pages d-flex align-items-center">
                                            <span class="displaying-num">{{$all_shelf->total()}} items</span>
                                            <span class="pagination-links d-flex">
                                                @if($all_shelf->currentPage() > 1)
                                                <a class="first-page btn {{$all_shelf->currentPage() > 1 ? '' : 'disable'}}" href="{{$all_decode_shelf->first_page_url}}" data-toggle="tooltip" data-placement="top" title="First Page">
                                                    <span class="screen-reader-text d-none">First page</span>
                                                    <span aria-hidden="true">«</span>
                                                </a>
                                                <a class="prev-page btn {{$all_shelf->currentPage() > 1 ? '' : 'disable'}}" href="{{$all_decode_shelf->prev_page_url}}" data-toggle="tooltip" data-placement="top" title="Previous Page">
                                                    <span class="screen-reader-text d-none">Previous page</span>
                                                    <span aria-hidden="true">‹</span>
                                                </a>
                                                @endif
                                                <span class="paging-input d-flex align-items-center">
                                                    <label for="current-page-selector" class="screen-reader-text d-none">Current Page</label>
                                                    <input class="current-page" id="current-page-selector" type="text" name="paged" value="{{$all_decode_shelf->current_page}}" size="3" aria-describedby="table-paging">
                                                    <span class="datatable-paging-text d-flex"> of <span class="total-pages">{{$all_decode_shelf->last_page}}</span></span>
                                                    <input type="hidden" name="route_name" value="shelf">
                                                </span>
                                                @if($all_shelf->currentPage() !== $all_shelf->lastPage())
                                                <a class="next-page btn" href="{{$all_decode_shelf->next_page_url}}" data-toggle="tooltip" data-placement="top" title="Next Page">
                                                    <span class="screen-reader-text d-none">Next page</span>
                                                    <span aria-hidden="true">›</span>
                                                </a>
                                                <a class="last-page btn" href="{{$all_decode_shelf->last_page_url}}" data-toggle="tooltip" data-placement="top" title="Last Page">
                                                    <span class="screen-reader-text d-none">Last page</span>
                                                    <span aria-hidden="true">»</span>
                                                </a>
                                                @endif
                                            </span>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <span class="search_result_show"></span>
                            <table class="shelf-table w-100">
                                <thead>
                                <form action="{{url('column-search')}}" method="post" id="shelfListForm">
                                @csrf
                                <input type="hidden" name="route_name" value="shelf">
                                <tr>
                                    <th style="width: 6%; text-align: center"><input type="checkbox" id="checkAll">
                                        <div class="product-inner">
                                            <select id="checkCondition" required>
                                                <option selected disabled>Select Option</option>
                                                <option value="1">Delete</option>
                                            </select>
                                        </div>
                                        <div class="product-inner"><button type="button" class="btn btn-default" onclick="deleteShelf()" style="cursor: pointer" data-toggle="tooltip" data-placement="top" title="Send">Send</button></div>
                                    </th>
                                    <th class="text-center" style="width: 10%">
                                        <div class="d-flex justify-content-center">
                                            <div class="btn-group">
                                                <a type="button" class="dropdown-toggle filter-btn" data-toggle="dropdown">
                                                    <i class="fa @isset($allCondition['id'])text-warning @endisset" aria-hidden="true"></i>
                                                </a>
                                                <div class="dropdown-menu filter-content shadow" role="menu">
                                                    <p>Filter Value</p>
                                                    <input type="number" class="form-control input-text" name="id" value="{{$allCondition['id'] ?? ''}}">
                                                    <div class="checkbox checkbox-custom checkbox m-t-10 m-b-10">
                                                        <input id="opt-out1" type="checkbox" name="id_opt_out" value="1" @isset($allCondition['id_opt_out']) checked @endisset><label for="opt-out1">Opt Out</label>
                                                    </div>
                                                    @if(isset($allCondition['id']))
                                                        <div class="individual_clr">
                                                            <button title="Clear filters" type="button" class='btn btn-outline-info clear-params'><i class="fas fa-times"></i></button>
                                                        </div>
                                                    @endif
                                                    <button type="submit" class="btn btn-primary filter-apply-btn float-right">Apply <i class="fa fa-arrow-circle-right ml-1"></i></button>
                                                </div>
                                            </div>
                                            <div>ID</div>
                                        </div>
                                    </th>
                                    <th class="text-center">
                                        <div class="d-flex justify-content-center">
                                            <div class="btn-group">
                                                <a type="button" class="dropdown-toggle filter-btn" data-toggle="dropdown">
                                                    <i class="fa @isset($allCondition['shelf_name'])text-warning @endisset" aria-hidden="true"></i>
                                                </a>
                                                <div class="dropdown-menu filter-content shadow" role="menu">
                                                    <p>Filter Value</p>
                                                    <input type="text" class="form-control input-text" name="shelf_name" value="{{$allCondition['shelf_name'] ?? ''}}">
                                                    <div class="checkbox checkbox-custom checkbox m-t-10 m-b-10">
                                                        <input id="opt-out2" type="checkbox" name="shelf_opt_out" value="1"  @isset($allCondition['shelf_opt_out']) checked @endisset><label for="opt-out2">Opt Out</label>
                                                    </div>
                                                    @if(isset($allCondition['shelf_name']))
                                                        <div class="individual_clr">
                                                            <button title="Clear filters" type="button" class='btn btn-outline-info clear-params'><i class="fas fa-times"></i></button>
                                                        </div>
                                                    @endif
                                                    <button type="submit" class="btn btn-primary filter-apply-btn float-right">Apply <i class="fa fa-arrow-circle-right ml-1"></i></button>
                                                </div>
                                            </div>
                                            <div>Shelf Name</div>
                                        </div>
                                    </th>
                                    <th class="text-center filter-symbol">
                                        <div class="d-flex justify-content-center">
                                            <div class="btn-group">
                                                <a type="button" class="dropdown-toggle filter-btn" data-toggle="dropdown">
                                                    <i class="fa @isset($allCondition['total_quantity'])text-warning @endisset" aria-hidden="true"></i>
                                                </a>
                                                <div class="dropdown-menu filter-content stock-filter-content shadow" role="menu">
                                                    <p>Filter Value</p>
                                                    <div class="d-flex">
                                                        <div>
                                                            <select class="form-control" name="total_quantity_opt">
                                                                <option value=""></option>
                                                                <option value="=" @if(isset($allCondition['total_quantity_opt']) && ($allCondition['total_quantity_opt'] == '=')) selected @endif>=</option>
                                                                <option value="<" @if(isset($allCondition['total_quantity_opt']) && ($allCondition['total_quantity_opt'] == '<')) selected @endif><</option>
                                                                <option value=">" @if(isset($allCondition['total_quantity_opt']) && ($allCondition['total_quantity_opt'] == '>')) selected @endif>></option>
                                                                <option value="<=" @if(isset($allCondition['total_quantity_opt']) && ($allCondition['total_quantity_opt'] == '≤')) selected @endif>≤</option>
                                                                <option value=">=" @if(isset($allCondition['total_quantity_opt']) && ($allCondition['total_quantity_opt'] == '≥')) selected @endif>≥</option>
                                                            </select>
                                                        </div>
                                                        <div class="ml-2">
                                                            <input type="number" class="form-control input-text symbol-filter-input-text" name="total_quantity" value="{{$allCondition['total_quantity'] ?? ''}}">
                                                        </div>
                                                    </div>
                                                    <div class="checkbox checkbox-custom checkbox m-t-10 m-b-10">
                                                        <input id="opt-out3" type="checkbox" name="total_quantity_opt_out" value="1" @isset($allCondition['total_quantity_opt_out']) checked @endisset><label for="opt-out3">Opt Out</label>
                                                    </div>
                                                    @if(isset($allCondition['total_quantity']))
                                                        <div class="individual_clr">
                                                            <button title="Clear filters" type="button" class='btn btn-outline-info clear-params'><i class="fas fa-times"></i></button>
                                                        </div>
                                                    @endif
                                                    <button type="submit" class="btn btn-primary filter-apply-btn float-right">Apply<i class="fa fa-arrow-circle-right ml-1"></i></button>
                                                </div>
                                            </div>
                                            <div>Total Product</div>
                                        </div>

                                    </th>
                                    <th class="text-center">Barcode</th>
                                    <th class="text-center">
                                        <div class="d-flex justify-content-center">
                                            <div class="btn-group">
                                                <a type="button" class="dropdown-toggle filter-btn" data-toggle="dropdown">
                                                    <i class="fa @isset($allCondition['user_id'])text-warning @endisset" aria-hidden="true"></i>
                                                </a>
                                                <div class="dropdown-menu filter-content shadow" role="menu">
                                                    <p>Filter Value</p>
                                                    <select class="form-control b-r-0" name="user_id" id="">
                                                        @isset($users)
                                                            @if($users->count() == 1)
                                                                @foreach($users as $user)
                                                                    <option value="{{$user->id}}">{{$user->name}}</option>
                                                                @endforeach
                                                            @else
                                                                <option value="">Select Creator</option>
                                                                @foreach($users as $user)
                                                                    @if(isset($allCondition['user_id']) && ($allCondition['user_id'] == $user->id))
                                                                        <option value="{{$user->id}}" selected>{{$user->name}}</option>
                                                                    @else
                                                                        <option value="{{$user->id}}">{{$user->name}}</option>
                                                                    @endif
                                                                @endforeach
                                                            @endif
                                                        @endisset
                                                    </select>
                                                    <div class="checkbox checkbox-custom checkbox m-t-10 m-b-10">
                                                        <input id="opt-out4" type="checkbox" name="user_id_opt_out" value="1" @isset($allCondition['user_id_opt_out']) checked @endisset><label for="opt-out4">Opt Out</label>
                                                    </div>
                                                    @if(isset($allCondition['user_id']))
                                                        <div class="individual_clr">
                                                            <button title="Clear filters" type="button" class='btn btn-outline-info clear-params'><i class="fas fa-times"></i></button>
                                                        </div>
                                                    @endif
                                                    <button type="submit" class="btn btn-primary filter-apply-btn float-right">Apply<i class="fa fa-arrow-circle-right ml-1"></i></button>
                                                </div>
                                            </div>
                                            <div>Creator</div>
                                        </div>
                                    </th>
                                    <th style="width: 10%">
                                        <div class="d-flex justify-content-center align-items-center">
                                            <div>Actions</div> &nbsp; &nbsp;
                                            @if(count($allCondition) > 0)
                                                <div><a title="Clear filters" href="{{asset('shelf')}}" class='btn btn-outline-info'><img src="{{asset('assets/common-assets/25.png')}}"></a></div>
                                            @endif
                                        </div>
                                    </th>
                                </tr>
                                </form>
                                </thead>

                                <tbody>
                                @isset($all_shelf)
                                    @if(count($all_shelf) == 0)
                                        <script type="text/javascript">
                                            $(document).ready(function() {
                                                Swal.fire(
                                                    'No result found',
                                                    '',
                                                    'info'
                                                )
                                            });
                                        </script>
                                    @endif
                                    @foreach($all_shelf as $index => $shelf)
                                        <tr>
                                            <td style="width: 6%; text-align: center !important;">
                                                {{--                                                    <input type="checkbox" class="checkBoxClass" id="customCheck{{$pending->id}}" name="multiple_order[]" value="{{$pending->id}}">--}}
                                                <input type="checkbox" class="checkBoxClass" id="checkItem{{$index}}" name="masterProduct[{{$index}}]" value="{{$shelf->id}}">
                                            </td>
                                            <td style="text-align: center !important; width: 10%">
                                                <div class="id_tooltip_container d-flex justify-content-center align-items-center">
                                                    <span title="Click to Copy" onclick="textCopiedID(this);" class="id_copy_button">{{$shelf->id}}</span>
                                                    <span class="wms__id__tooltip__message" id="wms__id__tooltip__message">Copied!</span>
                                                </div>
                                                 {{--loader added --}}
                                                 <div id="product_variation_loading" class="variation_load" style="display: none;"></div>
                                            </td>
                                            <td style="text-align: center !important;">
                                                <div class="id_tooltip_container d-flex justify-content-center align-items-center">
                                                    <span title="Click to Copy" onclick="textCopiedID(this);" class="id_copy_button">{{$shelf->shelf_name}}</span>
                                                    <span class="wms__id__tooltip__message" id="wms__id__tooltip__message">Copied!</span>
                                                </div>
                                            </td>
                                            @php
                                                $data = 0;
                                            @endphp
                                            @foreach($shelf->total_product as $total)
                                                @php
                                                    $data += $total->pivot->quantity;
                                                @endphp
                                            @endforeach
                                            <td style="text-align: center !important;">{{$data}}</td>
                                            <td style="text-align: center !important;">
                                                <span class="d-flex justify-content-center align-items-center">
                                                    <span class="d-flex justify-content-center align-items-center mr-2"> {!! \SimpleSoftwareIO\QrCode\Facades\QrCode::size(60)->generate($shelf->id); !!} </span>
                                                    <span class="d-flex justify-content-center align-items-center"><a href="{{url('print-shelf-barcode/'.$shelf->id)}}" class="btn btn-success print-barcode-btn" target="_blank">Print Qrcode</a></span>
                                                </span>
                                            </td>
                                            <td style="text-align: center !important;">{{$shelf->user->name ?? ''}}</td>

                                            <td class="shelf-action" style="width: 10% !important;">

                                                <!--action button-->
                                                <div class="d-flex justify-content-start align-items-center">

                                                    @if (Auth::check() && in_array('1',explode(',',Auth::user()->role)) || in_array('2',explode(',',Auth::user()->role)))
                                                        <a class="btn-size edit-btn mr-2" href="#editShelfList{{$shelf->id}}" data-animation="slit" data-plugin="custommodal"
                                                           data-overlaySpeed="100" data-overlayColor="#36404a"  data-placement="top" title="Edit"><i class="fa fa-edit" aria-hidden="true"></i></a>
                                                        <a class="btn-size view-btn mr-2" href="{{url('shelf/'.Crypt::encrypt($shelf->id))}}" target="_blank" data-toggle="tooltip" data-placement="top" title="View"><i class="fa fa-eye" aria-hidden="true"></i></a>

                                                        {{--                                                <form action="{{url('shelf/'.$shelf->id)}}" method="post">--}}
                                                        {{--                                                    @method('DELETE')--}}
                                                        {{--                                                    @csrf--}}
                                                        {{--                                                    <a href="#" class="on-default remove-row" ><button class="vendor_btn_delete btn-danger" onclick="return check_delete('shelf');">Delete</button>  </a>--}}
                                                        {{--                                                </form>--}}
                                                    @else
                                                        <a class="btn-size view-btn mr-2" href="{{url('shelf/'.Crypt::encrypt($shelf->id))}}" data-toggle="tooltip" data-placement="top" title="View"><i class="fa fa-eye" aria-hidden="true"></i></a>
                                                    @endif

                                                    <a class="btn-size migrate-btn dropdown-toggle" data-toggle="dropdown" href="" data-placement="top" title="Migrate"><i class="fas fa-exchange-alt"></i></a>
                                                    <div class="dropdown-menu filter-content shadow" role="menu">
                                                        <form action="{{url('shelf-migration')}}" method="post">
                                                            @csrf
                                                            <p class="mb-1">Migrate To</p>
                                                            <select class="form-control" name="to_id">
                                                                <option value="">Select Shelf</option>
                                                                @foreach($shelfs as $migrate_shelf)
                                                                    @if($migrate_shelf->id != $shelf->id)
                                                                        <option value="{{$migrate_shelf->id}}">{{$migrate_shelf->shelf_name}}</option>
                                                                    @endif
                                                                @endforeach
                                                            </select>
                                                            <input type="hidden" name="from_id" value="{{$shelf->id}}">
                                                            <button type="submit" class="btn btn-primary filter-apply-btn float-right mt-2">Apply<i class="fa fa-arrow-circle-right ml-1"></i></button>
                                                        </form>
                                                    </div>
                                                </div>


                                                <!-- Edit Shelf Modal -->
                                                <div id="editShelfList{{$shelf->id}}" class="modal-demo">
                                                    <button type="button" class="close" onclick="Custombox.close();">
                                                        <span>&times;</span><span class="sr-only">Close</span>
                                                    </button>
                                                    <h4 class="custom-modal-title">Change Shelf Name</h4>
                                                    <form role="form" class="vendor-form mobile-responsive" action="{{url('shelf/'.$shelf->id)}}" method="post">
                                                        @method('PUT')
                                                        @csrf
                                                        <div class="form-group row">
                                                            <div class="col-md-1"></div>
                                                            <label for="name" class="col-md-2 col-form-label ml-sm-25 mr-sm-25 ml-xs-25 mr-xs-25 required">Shelf Name</label>
                                                            <div class="col-md-8 ml-sm-25 mr-sm-25 ml-xs-25 mr-xs-25">
                                                                <input type="text" name="shelf_name" class="form-control" id="shelf_name" value="{{ $shelf->shelf_name ? $shelf->shelf_name : old('shelf_name') }}" placeholder="Enter Shelf Name" required>
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
                                                <!--End Edit Shelf Modal -->


                                            </td>
                                        </tr>
                                    @endforeach
                                @endisset
                                </tbody>
                            </table>
                                <!-- Modal HTML -->
                                <div id="myModal" class="modal fade" tabindex="-1">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
{{--                                                <h5 class="modal-title">Modal Title</h5>--}}
                                            <button type="button" onclick="refresh()" class="close" data-dismiss="modal">&times;</button>
                                            </div>
                                            <div class="modal-body">
                                                <p id="modalText"></p>
                                            </div>
                                            <div class="modal-footer">
{{--                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>--}}
{{--                                                <button type="button" class="btn btn-primary">Save</button>--}}
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            <!--table below pagination sec-->
                            <div class="row table-foo-sec">
                                <div class="col-md-6 d-flex justify-content-md-start align-items-center"> </div>
                                <div class="col-md-6">
                                    <div class="d-flex justify-content-md-end align-items-center py-2">
                                        <div class="pagination-area">
                                            <div class="datatable-pages d-flex align-items-center">
                                                <span class="displaying-num">{{$all_shelf->total()}} items</span>
                                                <span class="pagination-links d-flex">
                                                    @if($all_shelf->currentPage() > 1)
                                                    <a class="first-page btn {{$all_shelf->currentPage() > 1 ? '' : 'disable'}}" href="{{$all_decode_shelf->first_page_url}}" data-toggle="tooltip" data-placement="top" title="First Page">
                                                        <span class="screen-reader-text d-none">First page</span>
                                                        <span aria-hidden="true">«</span>
                                                    </a>
                                                    <a class="prev-page btn {{$all_shelf->currentPage() > 1 ? '' : 'disable'}}" href="{{$all_decode_shelf->prev_page_url}}" data-toggle="tooltip" data-placement="top" title="Previous Page">
                                                        <span class="screen-reader-text d-none">Previous page</span>
                                                        <span aria-hidden="true">‹</span>
                                                    </a>
                                                    @endif
                                                    <span class="screen-reader-text" style="display: none;">Current Page</span>
                                                    <span class="paging-input d-flex align-items-center">
                                                        <span class="datatable-paging-text d-flex pl-1"> {{$all_decode_shelf->current_page}} of <span class="total-pages"> {{$all_decode_shelf->last_page}} </span></span>
                                                    </span>
                                                    @if($all_shelf->currentPage() !== $all_shelf->lastPage())
                                                    <a class="next-page btn" href="{{$all_decode_shelf->next_page_url}}" data-toggle="tooltip" data-placement="top" title="Next Page">
                                                        <span class="screen-reader-text d-none">Next page</span>
                                                        <span aria-hidden="true">›</span>
                                                    </a>
                                                    <a class="last-page btn" href="{{$all_decode_shelf->last_page_url}}" data-toggle="tooltip" data-placement="top" title="Last Page">
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


    <!--Add Role Modal -->
    <div id="addShelf" class="modal-demo">
        <button type="button" class="close" onclick="Custombox.close();">
            <span>&times;</span><span class="sr-only">Close</span>
        </button>
        <h4 class="custom-modal-title">Add Shelf</h4>
        {{--                                <div class="modal-body">--}}

        <form role="form" class="vendor-form mobile-responsive" action="{{url('shelf')}}" method="post">
            @csrf
            <div class="form-group row">
                <div class="col-md-1"></div>
                <label for="name" class="col-md-2 col-form-label ml-sm-25 mr-sm-25 ml-xs-25 mr-xs-25 required">Shelf Name</label>
                <div class="col-md-8 ml-sm-25 mr-sm-25 ml-xs-25 mr-xs-25">
                    <input type="text" name="shelf_name" class="form-control" id="shelf_name" value="{{ old('shelf_name') }}" placeholder="Enter shelf name" required>
                </div> <div class="col-md-1"></div>

            </div>

            <div class="form-group row">
                <div class="col-md-12 text-center mb-5 mt-3">
                    <button type="submit" class="btn btn-primary vendor-btn waves-effect waves-light">
                        <b>Submit</b>
                    </button>
                </div>
            </div>
        </form>
    </div>
    <!--End Role Modal -->



    <script>
        $("#checkAll").click(function () {
            $('input:checkbox').not(this).prop('checked', this.checked);
        });
        function refresh(){
                location.reload();
        }
        function deleteShelf(){
            // console.log($("#checkCondition").val());
            var condition = $("#checkCondition").val();
            var url = '';
            if (condition == 1){
                url = 'delete-shelf';
            }
            if (condition != null){
                var shelf_id = [];
                $('table tbody tr td :checkbox:checked').each(function(i){
                    shelf_id[i] = $(this).val();
                });
                $.ajax({
                    type: "POST",
                    url: "{{URL::to('/')}}"+'/'+url,
                    data: {
                        "_token" : "{{csrf_token()}}",
                        "shelfs" : shelf_id,
                    },
                    beforeSend: function(){
                        // Show image container
                        $("#ajax_loader").show();
                    },
                    success: function (response) {
                        console.log(response)
                        if (response.shelf == null){
                            $("#modalText").text("Shelf deleted successfully")
                        }
                        $("#modalText").html("Please migrate products from shelf <strong>"+response.shelf+"</strong> before delete")
                        $("#myModal").modal('show');
                        $("#ajax_loader").hide();
                        console.log(response);
                        // if(response != 0) {
                        //     location.reload();
                        // }else{
                        //     // console.log('else');
                        //     alert(response);
                        // }
                    },
                    error: function(XMLHttpRequest, textStatus, errorThrown) {
                        // console.log('error');
                        $("#ajax_loader").hide();
                        //alert("Status: " + textStatus);
                        alert("Error: " + XMLHttpRequest.responseJSON.message);
                    }
                });
            }else{
                // $("#checkCondition").prop('required',true);
               alert("Select Option")
            }


        }

        //Datatable row-wise searchable option
        $(document).ready(function(){

            $("#in-row-id-name-wise-search").on("keyup", function() {
                let search_value = $(this).val();
                if(search_value == ''){
                    return false;
                }
                console.log(search_value);
                // $("#table-body tr").filter(function() {
                //     $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                // });
                $.ajax({
                    type: "post",
                    url: "{{url('shelf-search')}}",
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
                    $('#shelfListForm').submit()
                })
            })
        });

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

        //Select 2 dropdown
        $('.select2').select2();

        //sort ascending and descending table rows js
        // function sortTable(n) {
        //     let table,
        //         rows,
        //         switching,
        //         i,
        //         x,
        //         y,
        //         shouldSwitch,
        //         dir,
        //         switchcount = 0;
        //     table = document.getElementById("table-sort-list");
        //     switching = true;
        //     //Set the sorting direction to ascending:
        //     dir = "asc";
        //     /*Make a loop that will continue until
        //     no switching has been done:*/
        //     while (switching) {
        //         //start by saying: no switching is done:
        //         switching = false;
        //         rows = table.getElementsByTagName("TR");
        //         /*Loop through all table rows (except the
        //         first, which contains table headers):*/
        //         for (i = 1; i < rows.length - 1; i++) { //Change i=0 if you have the header th a separate table.
        //             //start by saying there should be no switching:
        //             shouldSwitch = false;
        //             /*Get the two elements you want to compare,
        //             one from current row and one from the next:*/
        //             x = rows[i].getElementsByTagName("TD")[n];
        //             y = rows[i + 1].getElementsByTagName("TD")[n];
        //             /*check if the two rows should switch place,
        //             based on the direction, asc or desc:*/
        //             if (dir == "asc") {
        //                 if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
        //                     //if so, mark as a switch and break the loop:
        //                     shouldSwitch = true;
        //                     break;
        //                 }
        //             } else if (dir == "desc") {
        //                 if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
        //                     //if so, mark as a switch and break the loop:
        //                     shouldSwitch = true;
        //                     break;
        //                 }
        //             }
        //         }
        //         if (shouldSwitch) {
        //             /*If a switch has been marked, make the switch
        //             and mark that a switch has been done:*/
        //             rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
        //             switching = true;
        //             //Each time a switch is done, increase this count by 1:
        //             switchcount++;
        //         } else {
        //             /*If no switching has been done AND the direction is "asc",
        //             set the direction to "desc" and run the while loop again.*/
        //             if (switchcount == 0 && dir == "asc") {
        //                 dir = "desc";
        //                 switching = true;
        //             }
        //         }
        //     }
        // }


        // sort ascending descending icon active and active-remove js
        // $('.header-cell').click(function() {
        //     let isSortedAsc  = $(this).hasClass('sort-asc');
        //     let isSortedDesc = $(this).hasClass('sort-desc');
        //     let isUnsorted = !isSortedAsc && !isSortedDesc;
        //
        //     $('.header-cell').removeClass('sort-asc sort-desc');
        //
        //     if (isUnsorted || isSortedDesc) {
        //         $(this).addClass('sort-asc');
        //     } else if (isSortedAsc) {
        //         $(this).addClass('sort-desc');
        //     }
        // });


    </script>


@endsection
