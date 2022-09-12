
@extends('master')

@section('title')
    eBay Profile | WMS360
@endsection


@section('content')
    <style>
        #div1, #div2 {
            float: left;
            width: 100px;
            height: 35px;
            margin: 10px;
            padding: 10px;
            border: 1px solid black;
        }
    </style>
    <script>
        function allowDrop(ev) {
            ev.preventDefault();
        }

        function drag(ev) {
            ev.dataTransfer.setData("text", ev.target.id);
        }

        function drop(ev) {
            ev.preventDefault();
            var data = ev.dataTransfer.getData("text");
            ev.target.appendChild(document.getElementById(data));
        }
    </script>

    <div class="content-page">
        <!-- Start content -->
        <div class="content">
            <div class="container-fluid">

                <!--Page title-->
                <div class="wms-breadcrumb">
                    <ol class="breadcrumb page-breadcrumb">
                        <li class="breadcrumb-item">eBay</li>
                        <li class="breadcrumb-item active" aria-current="page">Profile</li>
                    </ol>
                    <div class="breadcrumbRightSideBtn">
                        <a href="{{url('ebay-profile/create')}}" target="_blank"><button class="btn btn-default waves-effect waves-light"> Add eBay Profile </button></a>
                    </div>
                </div>



                <div class="row m-t-20">
                    {{--                    <div id="div1" ondrop="drop(event)" ondragover="allowDrop(event)">--}}
                    {{--                        <img src="img_w3slogo.gif" draggable="true" ondragstart="drag(event)" id="drag1" width="88" height="31">--}}
                    {{--                    </div>--}}

                    {{--                    <div id="div2" ondrop="drop(event)" ondragover="allowDrop(event)"></div>--}}
                    <div class="col-md-12">
                        <div class="card-box ebay table-responsive ebay-card-box shadow">


                            @if (Session::has('attribute_delete_success_msg'))
                                <div class="alert alert-danger">
                                    {!! Session::get('attribute_delete_success_msg') !!}
                                </div>
                            @endif


                                <div class="m-b-20 m-t-10">
                                    <div class="product-inner">

                                        <div class="ebay-master-product-search-form">
                                            <form class="d-flex" action="{{URL('ebay/profile/search')}}" method="post">
                                                @csrf
{{--                                                <div class="row-wise-search ebay-profile-search">--}}
{{--                                                    <input class="form-control" id="row-wise-search" type="text" placeholder="Search On eBay...">--}}
{{--                                                </div>--}}
                                                <div class="p-text-area">
                                                    <input type="text" name="search_value" id="search_value" class="form-control" placeholder="Search On eBay...">
                                                </div>
                                                <input type="hidden" name="route_name" value="ebay-profile-name-list">
                                                <div class="submit-btn">
                                                    <button type="submit" class="search-btn waves-effect waves-light" onclick="ebay_profile_search()">Search</button>
                                                </div>
                                            </form>
                                        </div>

                                        <div class="pagination-area">
                                            <form action="{{'pagination-all'}}" method="post">
                                                @csrf
                                                <div class="datatable-pages d-flex align-items-center">
                                                    <span class="displaying-num"> {{$results->total()}} items</span>
                                                    <span class="pagination-links d-flex">
                                                        @if($results->currentPage() > 1)
                                                        <a class="first-page btn {{$results->currentPage() > 1 ? '' : 'disabled'}}" href="{{$all_decode_EbayProfile->first_page_url}}" data-toggle="tooltip" data-placement="top" title="First Page">
                                                            <span class="screen-reader-text d-none">First page</span>
                                                            <span aria-hidden="true">«</span>
                                                        </a>
                                                        <a class="prev-page btn {{$results->currentPage() > 1 ? '' : 'disabled'}}" href="{{$all_decode_EbayProfile->prev_page_url}}" data-toggle="tooltip" data-placement="top" title="Previous Page">
                                                            <span class="screen-reader-text d-none">Previous page</span>
                                                            <span aria-hidden="true">‹</span>
                                                        </a>
                                                        @endif
                                                        <span class="paging-input d-flex align-items-center">
                                                            <label for="current-page-selector" class="screen-reader-text d-none">Current Page</label>
                                                            <input class="current-page" id="current-page-selector" type="text" name="paged" value="{{$all_decode_EbayProfile->current_page}}" size="3" aria-describedby="table-paging">
                                                            <span class="datatable-paging-text d-flex">of<span class="total-pages">{{$all_decode_EbayProfile->last_page}}</span></span>
                                                            <input type="hidden" name="route_name" value="ebay-profile">
                                                        </span>
                                                        @if($results->currentPage()  !== $results->lastPage())
                                                        <a class="next-page btn" href="{{$all_decode_EbayProfile->next_page_url}}" data-toggle="tooltip" data-placement="top" title="Next Page">
                                                            <span class="screen-reader-text d-none">Next page</span>
                                                            <span aria-hidden="true">›</span>
                                                        </a>
                                                        <a class="last-page btn" href="{{$all_decode_EbayProfile->last_page_url}}" data-toggle="tooltip" data-placement="top" title="Last Page">
                                                            <span class="screen-reader-text d-none">Last page</span>
                                                            <span aria-hidden="true">»</span>
                                                        </a>
                                                        @endif
                                                    </span>
                                                </div>
                                            </form>
                                        </div>


                                    </div>
                                </div>


                                <!--Start Loader-->
                                <div id="Load" class="load" style="display: none;">
                                    <div class="load__container">
                                        <div class="load__animation"></div>
                                        <div class="load__mask"></div>
                                        <span class="load__title">Content id loading...</span>
                                    </div>
                                </div>
                                <!--End Loader-->



                                <table class="ebay-table ebay-table-n w-100 table-primary-btm">
                                <thead>
                                <tr>
                                    <th style="width: 30%">Profile Name</th>
                                    <th class="text-center" style="width: 20%">Site Name</th>
                                    <th style="width: 30%">Category</th>
                                    <th class="text-center" style="width: 14%">Account Name</th>
                                    <th style="width: 6%">Action</th>
                                </tr>
                                </thead>
                                <tbody id="table-body">
                                @isset($results)
                                    @foreach($results as $result)
                                        <tr>
                                            <td style="width: 30%">
                                                <div class="id_tooltip_container d-flex justify-content-start align-items-start">
                                                    <span title="Click to Copy" onclick="textCopiedID(this);" class="id_copy_button id_copy_button_ebay_profile_name">{{$result->profile_name}}</span>
                                                    <span class="wms__id__tooltip__message" id="wms__id__tooltip__message">Copied!</span>
                                                </div>
                                            </td>
                                            <td class="text-center" style="width: 20%">
                                                {{\App\EbaySites::find($result->site_id)->name}}
                                            </td>
                                            <td style="width: 30%">
                                                {{$result->category_name}}
                                            </td>
                                            <td class="text-center" style="width: 14%">{{\App\EbayAccount::find($result->account_id)->account_name ?? ''}}</td>
                                            <td class="actions" style="width: 6%">
                                                <div class="btn-group dropup">
                                                    <button type="button" class="btn manage-btn dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        Manage
                                                    </button>
                                                    <div class="dropdown-menu">
                                                        <!-- Dropdown menu links -->
                                                        <div class="dropup-content">
                                                            <div class="d-flex justify-content-start align-items-center">
{{--                                                                <a href="{{URL::to('ebay-profile/'.$result->id.'/edit')}}" ><button class="vendor_btn_edit btn-primary">Edit</button></a>&nbsp;--}}
{{--                                                                <a target="_blank" href="{{URL::to('ebay-profile/'.$result->id.'/duplicate')}}" ><button class="vendor_btn_edit btn-primary">Duplicate</button></a>&nbsp;--}}
                                                                <div class="align-items-center mr-2"><a class="btn-size edit-btn" href="{{URL::to('ebay-profile/'.$result->id.'/edit')}}" target="_blank" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-edit" aria-hidden="true"></i></a></div>
                                                                <div class="align-items-center mr-2"> <a class="btn-size duplicate-btn" href="{{URL::to('ebay-profile/'.$result->id.'/duplicate')}}" target="_blank" data-toggle="tooltip" data-placement="top" title="Duplicate"><i class="fa fa-clone" aria-hidden="true"></i></a></div>
                                                                {{--                                                <a href="{{url('attribute/'.$attribute->id)}}" ><button class="vendor_btn_view btn-success">View</button></a>&nbsp;--}}
                                                                <div>
                                                                    <form action="{{url('ebay-profile/'.$result->id)}}" method="post">
                                                                        @method('DELETE')
                                                                        @csrf
{{--                                                                        <a href="#" class="on-default remove-row" ><button class="vendor_btn_delete btn-danger" onclick="return check_delete('attribute');">Delete</button>  </a>--}}
                                                                        <button class="btn-size del-pub del-pub-n delete-btn on-default remove-row" style="cursor: pointer" href="#" data-toggle="tooltip" data-placement="top" title="Delete" onclick="return check_delete('attribute');"><i class="fa fa-trash" aria-hidden="true"></i></button>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                            </td>
                                        </tr>
                                    @endforeach
                                @endisset
                                </tbody>
                            </table>


                                <!--table below pagination sec-->
                                <div class="row table-foo-sec">
                                    <div class="col-md-6 d-flex justify-content-md-start align-items-center"></div>
                                    <div class="col-md-6">
                                        <div class="d-flex justify-content-md-end align-items-center py-2">
                                            <div class="pagination-area">
                                                <div class="datatable-pages d-flex align-items-center">
                                                    <span class="displaying-num pr-1"> {{$results->total()}} items</span>
                                                        <span class="pagination-links d-flex">
                                                        @if($results->currentPage() > 1)
                                                        <a class="first-page btn {{$results->currentPage() > 1 ? '' : 'disabled'}}" href="{{$all_decode_EbayProfile->first_page_url}}" data-toggle="tooltip" data-placement="top" title="First Page">
                                                            <span class="screen-reader-text d-none">First page</span>
                                                            <span aria-hidden="true">«</span>
                                                        </a>
                                                        <a class="prev-page btn {{$results->currentPage() > 1 ? '' : 'disabled'}}" href="{{$all_decode_EbayProfile->prev_page_url}}" data-toggle="tooltip" data-placement="top" title="Previous Page">
                                                            <span class="screen-reader-text d-none">Previous page</span>
                                                            <span aria-hidden="true">‹</span>
                                                        </a>
                                                        @endif
                                                        <span class="screen-reader-text" style="display: none;">Current Page</span>
                                                        <span class="paging-input d-flex align-items-center">
                                                            <span class="datatable-paging-text  d-flex pl-1"> {{$all_decode_EbayProfile->current_page}} of <span class="total-pages">{{$all_decode_EbayProfile->last_page}}</span></span>
                                                        </span>
                                                        @if($results->currentPage()  !== $results->lastPage())
                                                        <a class="next-page btn" href="{{$all_decode_EbayProfile->next_page_url}}" data-toggle="tooltip" data-placement="top" title="Next Page">
                                                            <span class="screen-reader-text d-none">Next page</span>
                                                            <span aria-hidden="true">›</span>
                                                        </a>
                                                        <a class="last-page btn" href="{{$all_decode_EbayProfile->last_page_url}}" data-toggle="tooltip" data-placement="top" title="Last Page">
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

    </div>   <!-- content page -->




    <script>
        // Datatable row-wise searchable option
        $(document).ready(function(){
            $("#row-wise-search").on("keyup", function() {
                let value = $(this).val().toLowerCase();
                $("#table-body tr").filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });

            });
        });


        function ebay_profile_search(){
            var name = $('#search_value').val();
            if(name == '' ){
                alert('Please type eBay profile name in the search field.');
            }
        }
    </script>



@endsection
