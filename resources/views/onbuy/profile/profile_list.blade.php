@extends('master')

@section('title')
    Profile | WMS360
@endsection

@section('content')
    <div class="content-page">
        <!-- Start content -->
        <div class="content">
            <div class="container-fluid">


                <!----ON OFF SWITCH ARRAY KEY DECLARATION---->
                <input type="hidden" id="firstKey" value="onbuy">
                <input type="hidden" id="secondKey" value="onbuy_profile">
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
                            <li class="breadcrumb-item">OnBuy</li>
                            <li class="breadcrumb-item active" aria-current="page">Profile</li>
                        </ol>
                    </div>
                    <div class="screen-option-btn">
                        <button class="btn btn-link waves-effect waves-light" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                            Screen Options &nbsp; <i class="fa" aria-hidden="true"></i>
                        </button>
                        <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion"></div>
                    </div>
                </div>




                <!---Assigned order content start--->
                <div class="row m-t-20 order-content">
                    <div class="col-md-12">
                        <div class="card-box onbuy table-responsive shadow">

                            @if($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach($errors->all() as $error)
                                            <li>{{$error}}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            @if(Session::has('success'))
                                <div class="alert alert-success">
                                    <button type="button" class="close" data-dismiss="alert">×</button>
                                    {!! Session::get('success') !!}
                                </div>
                            @endif


                            <div class="m-b-20 m-t-10">
                                <div class="product-inner">

                                    <div class="onbuy-search-form">
                                        <form class="d-flex" action="Javascript:void(0);" method="post">
                                            <div class="p-text-area">
{{--                                                <input type="text" name="name" id="name" class="form-control" placeholder="Search by ID or catalogue Name...." required>--}}
                                                <input type="text" class="form-control" placeholder="Search on OnBuy...." name="search" id="search_profile">
                                            </div>
                                            <div class="submit-btn">
{{--                                                <button class="search-btn waves-effect waves-light" type="submit" onclick="publish_catalogue_search();">Search</button>--}}
                                                <button id="search-btn" type="submit" class="search-profile-btn waves-effect waves-light">Search</button>
                                            </div>
                                        </form>
                                    </div>

                                    <!--start pagination area-->
                                    <div class="pagination-area">
                                        <form action="{{url('pagination-all')}}" method="post">
                                            @csrf
                                            <div class="datatable-pages d-flex align-items-center">
                                                <span class="displaying-num">{{count($profile_lists)}} items</span>
                                                <span class="pagination-links d-flex">
                                                    @if($profile_lists->currentPage() > 1)
                                                    <a class="first-page btn {{$profile_lists->currentPage() > 1 ? '' : 'disable'}}" href="{{$all_decode_profile_list->first_page_url}}" data-toggle="tooltip" data-placement="top" title="First Page">
                                                        <span class="screen-reader-text d-none">First page</span>
                                                        <span aria-hidden="true">«</span>
                                                    </a>
                                                    <a class="prev-page btn {{$profile_lists->currentPage() > 1 ? '' : 'disable'}}" href="{{$all_decode_profile_list->prev_page_url}}" data-toggle="tooltip" data-placement="top" title="Previous Page">
                                                        <span class="screen-reader-text d-none">Previous page</span>
                                                        <span aria-hidden="true">‹</span>
                                                    </a>
                                                    @endif
                                                    <span class="paging-input d-flex align-items-center">
                                                        <label for="current-page-selector" class="screen-reader-text d-none">Current Page</label>
                                                        <input class="current-page" id="current-page-selector" type="text" name="paged" value="{{$all_decode_profile_list->current_page}}" size="3" aria-describedby="table-paging">
                                                        <span class="datatable-paging-text d-flex">of<span class="total-pages">{{$all_decode_profile_list->last_page}}</span></span>
                                                        <input type="hidden" name="route_name" value="onbuy/profile-list">
                                                    </span>
                                                    @if($profile_lists->currentPage() !== $profile_lists->lastPage())
                                                    <a class="next-page btn" href="{{$all_decode_profile_list->next_page_url}}" data-toggle="tooltip" data-placement="top" title="Next Page">
                                                        <span class="screen-reader-text d-none">Next page</span>
                                                        <span aria-hidden="true">›</span>
                                                    </a>
                                                    <a class="last-page btn" href="{{$all_decode_profile_list->last_page_url}}" data-toggle="tooltip" data-placement="top" title="Last Page">
                                                        <span class="screen-reader-text d-none">Last page</span>
                                                        <span aria-hidden="true">»</span>
                                                    </a>
                                                    @endif
                                                </span>
                                            </div>
                                        </form>
                                    </div>
                                    <!--End pagination area-->

                                </div>
                            </div>


                                    <div class="alert alert-danger alert-dismissible" style="display: none;">
                                        <button type="button" class="close" data-dismiss="alert">×</button>
                                        <strong>No profile found by this search value. Please try agian with exact Profile name or Category ID</strong>
                                    </div>


                                    <table class="onbuy-table w-100" style="border-collapse:collapse;">
                                        <thead>
                                        <tr>
                                            {{--                                        <th><input type="checkbox" id="ckbCheckAll"><label for="selectall"></label></th>--}}
                                            <th class="category-id" style="width: 15%">
                                                <div class="d-flex justify-content-center">
                                                    <div class="btn-group">
                                                        <form action="" method="">
                                                            <a type="button" class="dropdown-toggle filter-btn" data-toggle="dropdown">
                                                                <i class="fa" aria-hidden="true"></i>
                                                            </a>
                                                            <div class="dropdown-menu filter-content shadow" role="menu">
                                                                <p>Filter Value</p>
                                                                <input type="number" class="form-control input-text" name="">
                                                                <div class="checkbox checkbox-custom checkbox m-t-10 m-b-10">
                                                                    <input id="opt-out1" type="checkbox" name="opt_out1" value="1"><label for="opt-out1">Opt Out</label>
                                                                </div>
                                                                <input type="hidden" name="" value="">
                                                                <input type="hidden" name="" value="">
                                                                <button type="submit" class="btn btn-primary filter-apply-btn float-right">Apply <i class="fa fa-arrow-circle-right ml-1"></i></button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                    <div>Category ID</div>
                                                </div>
                                            </th>
                                            <th class="name" style="width: 20%">
                                                <div class="d-flex justify-content-start">
                                                    <div class="btn-group">
                                                        <form action="" method="">
                                                            <a type="button" class="dropdown-toggle filter-btn" data-toggle="dropdown">
                                                                <i class="fa" aria-hidden="true"></i>
                                                            </a>
                                                            <div class="dropdown-menu filter-content shadow" role="menu">
                                                                <p>Filter Value</p>
                                                                <input type="text" class="form-control input-text" name="">
                                                                <div class="checkbox checkbox-custom checkbox m-t-10 m-b-10">
                                                                    <input id="opt-out2" type="checkbox" name="opt_out2" value="1"><label for="opt-out2">Opt Out</label>
                                                                </div>
                                                                <input type="hidden" name="" value="">
                                                                <input type="hidden" name="" value="">
                                                                <button type="submit" class="btn btn-primary filter-apply-btn float-right">Apply <i class="fa fa-arrow-circle-right ml-1"></i></button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                    <div>Name</div>
                                                </div>
                                            </th>
                                            <th class="tree" style="width: 50%">
                                                <div class="d-flex justify-content-start">
                                                    <div class="btn-group">
                                                        <form action="" method="">
                                                            <a type="button" class="dropdown-toggle filter-btn" data-toggle="dropdown">
                                                                <i class="fa" aria-hidden="true"></i>
                                                            </a>
                                                            <div class="dropdown-menu filter-content shadow" role="menu">
                                                                <p>Filter Value</p>
                                                                <input type="text" class="form-control input-text" name="">
                                                                <div class="checkbox checkbox-custom checkbox m-t-10 m-b-10">
                                                                    <input id="opt-out3" type="checkbox" name="opt_out3" value="1"><label for="opt-out3">Opt Out</label>
                                                                </div>
                                                                <input type="hidden" name="" value="">
                                                                <input type="hidden" name="" value="">
                                                                <button type="submit" class="btn btn-primary filter-apply-btn float-right">Apply <i class="fa fa-arrow-circle-right ml-1"></i></button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                    <div>Tree</div>
                                                </div>
                                            </th>
                                            <th class="brand" style="width: 10%">
                                                <div class="d-flex justify-content-center">
                                                    <div class="btn-group">
                                                        <form action="" method="">
                                                            <a type="button" class="dropdown-toggle filter-btn" data-toggle="dropdown">
                                                                <i class="fa" aria-hidden="true"></i>
                                                            </a>
                                                            <div class="dropdown-menu filter-content shadow" role="menu">
                                                                <p>Filter Value</p>
                                                                <input type="text" class="form-control input-text" name="">
                                                                <div class="checkbox checkbox-custom checkbox m-t-10 m-b-10">
                                                                    <input id="opt-out4" type="checkbox" name="opt_out4" value="1"><label for="opt-out4">Opt Out</label>
                                                                </div>
                                                                <input type="hidden" name="" value="">
                                                                <input type="hidden" name="" value="">
                                                                <button type="submit" class="btn btn-primary filter-apply-btn float-right">Apply <i class="fa fa-arrow-circle-right ml-1"></i></button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                    <div>Brand</div>
                                                </div>
                                            </th>
                                            <th style="width: 10%">Actions</th>
                                        </tr>
                                        </thead>
                                        <tbody id="append_profile_info" class="table-body">
                                        @isset($profile_lists)
                                            @foreach($profile_lists as $key => $profile)
                                                <tr>
                                                    {{--                                            <td>--}}
                                                    {{--                                                <input type="checkbox" class=" checkBoxClass" id="customCheck{{$profile->id}}" name="multiple_checkbox[]" value="{{$profile->id}}">--}}
                                                    {{--                                            </td>--}}
                                                    <td class="category-id" style="cursor: pointer; width: 15% !important; text-align: center !important;" data-toggle="collapse" data-target="#demo{{$profile->id}}" class="accordion-toggle">
                                                        <div class="id_tooltip_container d-flex justify-content-center align-items-center">
                                                            <span title="Click to Copy" onclick="textCopiedID(this);" class="id_copy_button">{{$profile->last_category_id}}</span>
                                                            <span class="wms__id__tooltip__message" id="wms__id__tooltip__message">Copied!</span>
                                                        </div>
                                                    </td>
                                                    <td class="name" style="cursor: pointer; width: 20%" data-toggle="collapse" data-target="#demo{{$profile->id}}" class="accordion-toggle">
                                                        <div class="id_tooltip_container d-flex justify-content-start align-items-center">
                                                            <span title="Click to Copy" onclick="textCopiedID(this);" class="id_copy_button profile_name_id_copy_button">{{$profile->name}}</span>
                                                            <span class="wms__id__tooltip__message" id="wms__id__tooltip__message">Copied!</span>
                                                        </div>
                                                    </td>
                                                    <td class="tree" style="cursor: pointer; width: 50%" data-toggle="collapse" data-target="#demo{{$profile->id}}" class="accordion-toggle">
                                                        @foreach(unserialize($profile->category_ids) as $category)
                                                            / {{\App\OnbuyCategory::find($category)->name}}
                                                        @endforeach
                                                    </td>
                                                    <td class="brand" style="cursor: pointer; width: 10%; text-align: center !important;" data-toggle="collapse" data-target="#demo{{$profile->id}}" class="accordion-toggle">
                                                        @if($profile->brand)
                                                            {{\App\OnbuyBrand::find($profile->brand)->name}}
                                                        @endif
                                                    </td>
                                                    <td style="width: 10%">
                                                        <div class="btn-group dropup">
                                                            <button type="button" class="btn manage-btn dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                Manage
                                                            </button>
                                                            <div class="dropdown-menu">
                                                                <div class="dropup-content catalogue-dropup-content">
                                                                    <div class="action-1">
{{--                                                                        <a href="{{url('onbuy/edit-profile/'.$profile->id)}}"--}}
{{--                                                                           class="btn btn-primary btn-sm" data-toggle="tooltip" target="_" data-placement="top" title="Edit Profile">Edit</a>--}}
                                                                        <div class="mr-2"><a class="btn-size edit-btn" href="{{url('onbuy/edit-profile/'.$profile->id)}}" target="_blank" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-edit" aria-hidden="true"></i></a></div>
{{--                                                                        <a href="{{url('onbuy/duplicate-profile/'.$profile->id)}}"--}}
{{--                                                                           class="btn btn-success btn-sm" data-toggle="tooltip" target="_blank" data-placement="top" title="Duplicate Profile">Duplicate</a>--}}
                                                                        <div class="mr-2"><a class="btn-size duplicate-btn" href="{{url('onbuy/duplicate-profile/'.$profile->id)}}" data-toggle="tooltip" target="_blank" data-placement="top" title="Duplicate Profile"><i class="fa fa-clone" aria-hidden="true"></i></a></div>
                                                                        <div class="align-items-center">
                                                                            <form action="{{url('onbuy/delete-onbuy-profile/'.$profile->id)}}" method="post">
                                                                                @method('DELETE')
                                                                                @csrf
{{--                                                                                <a href="#" class="on-default remove-row" data-toggle="tooltip" data-placement="top" title="Delete Profile">--}}
                                                                                    <button class="del-pub delete-btn on-default remove-row" style="cursor: pointer" href="#" onclick="return check_delete('profile');" data-toggle="tooltip" data-placement="top" title="Delete Profile"><i class="fa fa-trash" aria-hidden="true"></i></button>
{{--                                                                                </a>--}}
                                                                            </form>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td colspan="5" class="hiddenRow">
                                                        <div class="accordian-body collapse" id="demo{{$profile->id}}">
                                                            <div class="row">
                                                                <div class="col-12">
                                                                    <div class="card p-2 m-t-5 m-b-5 m-l-5 m-r-5">
                                                                        <!--- Shipping Billing --->
                                                                        <div style="border: 1px solid #ccc" class="m-t-20">
                                                                            <div class="row px-4 py-3">
                                                                                <div class="col-md-6">
                                                                                    <div class="d-block mb-5">
                                                                                        <h6> Summary Points </h6>
                                                                                        <hr class="m-t-5 float-left" width="100%">
                                                                                    </div>
                                                                                    <div class="row">
                                                                                        <div class="d-flex justify-content-start mb-1">
                                                                                            <div class="content-right">
                                                                                                @isset($profile->summery_points)
                                                                                                    <ol>
                                                                                                        @foreach(unserialize($profile->summery_points) as $summary)
                                                                                                            <li>{{$summary}}</li>
                                                                                                        @endforeach
                                                                                                    </ol>
                                                                                                @endisset
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-md-6">
                                                                                    <div class="d-block mb-5">
                                                                                        <h6> Product Data </h6>
                                                                                        <hr class="m-t-5 float-left"
                                                                                            width="100%">
                                                                                    </div>
                                                                                    @isset($profile->master_product_data)
                                                                                        @foreach(unserialize($profile->master_product_data) as $key => $value)
                                                                                            <div class="row">
                                                                                                <div class="col-md-3 m-b-5">{{$key}}</div>
                                                                                                <div class="col-md-9 m-b-5">{{$value}}</div>
                                                                                            </div>
                                                                                        @endforeach
                                                                                    @endisset
                                                                                </div>
                                                                            </div>
                                                                            <div class="row px-4 py-3">
                                                                                <div class="col-md-6">
                                                                                    <div class="d-block mb-5">
                                                                                        <h6> Features </h6>
                                                                                        <hr class="m-t-5 float-left"
                                                                                            width="100%">
                                                                                    </div>
                                                                                    @isset($profile->features)
                                                                                        @foreach(unserialize($profile->features) as $value)
                                                                                            <div class="row">
                                                                                                <div class="col-md-3 m-b-5">{{$value ? (explode('/',$value)[1] ?? '') : ''}}</div>
                                                                                                <div class="col-md-9 m-b-5">{{$value ? (explode('/',$value)[2] ?? '') : ''}}</div>
                                                                                            </div>
                                                                                        @endforeach
                                                                                    @endisset
                                                                                </div>
                                                                                <div class="col-md-6">
                                                                                    <div class="d-block mb-5">
                                                                                        <h6> Technical Details </h6>
                                                                                        <hr class="m-t-5 float-left"
                                                                                            width="100%">
                                                                                    </div>
                                                                                    @isset($profile->technical_details)
                                                                                        @foreach(unserialize($profile->technical_details) as $value)
                                                                                            <div class="row">
                                                                                                <div class="col-md-3 m-b-5">{{$value ? (explode('/',$value)[0] ?? '') : ''}}</div>
                                                                                                <div class="col-md-9 m-b-5">{{$value ? (explode('/',$value)[1] ?? '') : ''}}</div>
                                                                                            </div>
                                                                                        @endforeach
                                                                                    @endisset
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div> <!-- end card -->
                                                                </div> <!-- end col-12 -->
                                                            </div> <!-- end row -->
                                                        </div> <!-- end accordion body -->
                                                    </td> <!-- hide expand td-->
                                                </tr> <!-- hide expand row-->
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
                                                        <span class="displaying-num">{{count($profile_lists)}} items</span>
                                                        <span class="pagination-links d-flex">
                                                            @if($profile_lists->currentPage() > 1)
                                                            <a class="first-page btn {{$profile_lists->currentPage() > 1 ? '' : 'disable'}}" href="{{$all_decode_profile_list->first_page_url}}" data-toggle="tooltip" data-placement="top" title="First Page">
                                                                <span class="screen-reader-text d-none">First page</span>
                                                                <span aria-hidden="true">«</span>
                                                            </a>
                                                            <a class="prev-page btn {{$profile_lists->currentPage() > 1 ? '' : 'disable'}}" href="{{$all_decode_profile_list->prev_page_url}}" data-toggle="tooltip" data-placement="top" title="Previous Page">
                                                                <span class="screen-reader-text d-none">Previous page</span>
                                                                <span aria-hidden="true">‹</span>
                                                            </a>
                                                            @endif
                                                            <span class="screen-reader-text" style="display: none;">Current Page</span>
                                                            <span class="paging-input d-flex align-items-center">
                                                                <span class="datatable-paging-text d-flex pl-1">{{$all_decode_profile_list->current_page}} of <span class="total-pages">{{$all_decode_profile_list->last_page}}</span></span>
                                                            </span>
                                                            @if($profile_lists->currentPage() !== $profile_lists->lastPage())
                                                            <a class="next-page btn" href="{{$all_decode_profile_list->next_page_url}}" data-toggle="tooltip" data-placement="top" title="Next Page">
                                                                <span class="screen-reader-text d-none">Next page</span>
                                                                <span aria-hidden="true">›</span>
                                                            </a>
                                                            <a class="last-page btn" href="{{$all_decode_profile_list->last_page_url}}" data-toggle="tooltip" data-placement="top" title="Last Page">
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

                        </div> <!--//END card box--->
                    </div> <!-- // col-md-12 -->
                </div> <!-- end row -->


            </div> <!-- container -->
        </div> <!-- content -->
    </div> <!-- content page -->



    <script>
        // table row expand and collapse
        $('.accordian-body').on('show.bs.collapse', function () {
            $(this).closest("table")
                .find(".collapse.in")
                .not(this)
                .collapse('toggle')
        })
        //End table row expand and collapse




        $(document).ready(function () {
            $("#ckbCheckAll").click(function () {
                $(".checkBoxClass").prop('checked', $(this).prop('checked'));
            });

            $(".checkBoxClass").change(function () {
                if (!$(this).prop("checked")) {
                    $("#ckbCheckAll").prop("checked", false);
                }
            });

            $('.search-profile-btn').on('click', function () {
                var profile_search_value = $('#search_profile').val();
                console.log(profile_search_value);

                $.ajax({
                    type: "post",
                    url: "{{url('onbuy/search-profile')}}",
                    data: {
                        "_token": "{{csrf_token()}}",
                        "search_value": profile_search_value
                    },
                    success: function (response) {
                        console.log(response);
                        if(response !== '') {
                            $('.alert-danger').hide();
                            $('#append_profile_info').html(response);
                        }else{
                            $('.alert-danger').show();
                            // $(".alert-danger").fadeTo(10000, 10000).slideUp(2000, function(){
                            //     $(".alert-danger").slideUp(2000);
                            // });
                        }
                    }
                });
            });

        });


        //Datatable row-wise searchable option
        $(document).ready(function(){
            $("#row-wise-search").on("keyup", function() {
                let value = $(this).val().toLowerCase();
                $("#table-body tr").filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });

            });
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
        //     table = document.getElementById("onbuy-profile-list");
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
        //
        //
        // // sort ascending descending icon active and active-remove js
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
