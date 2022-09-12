
@extends('master')

@section('title')
    WooCommerce | Category | WMS360
@endsection

@section('content')

    <!-- Custombox -->
    <link href="{{asset('assets/plugins/custombox/css/custombox.css')}}" rel="stylesheet">

    <!-- Modal-Effect -->
    <script src="{{asset('assets/plugins/custombox/js/custombox.min.js')}}"></script>
    <script src="{{asset('assets/plugins/custombox/js/legacy.min.js')}}"></script>

<style>
    .not_allowed {
        cursor: not-allowed !important;
    }
</style>

    <div class="content-page">
        <!-- Start content -->
        <div class="content">
            <div class="container-fluid">

                <!----ON OFF SWITCH ARRAY KEY DECLARATION---->
                <input type="hidden" id="firstKey" value="woocommerce">
                <input type="hidden" id="secondKey" value="woocommerce_category_list">
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
                                    <a href="#addCategory" data-animation="slit" data-plugin="custommodal" data-overlaySpeed="100" data-overlayColor="#36404a"><button class="btn btn-default">Add Category</button></a>&nbsp;
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <!--//screen option-->



                <div class="screen-option">
                    <div class="d-flex justify-content-start align-items-center">
                        <ol class="breadcrumb page-breadcrumb">
                            <li class="breadcrumb-item"> WooCommerce </li>
                            <li class="breadcrumb-item active" aria-current="page"> Category </li>
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
                        <div class="card-box table-responsive shadow category-card">


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

                            @if (Session::has('category_edit_success_msg'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    {!! Session::get('category_edit_success_msg') !!}
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif

                            @if (Session::has('category_delete_success_msg'))
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    {!! Session::get('category_delete_success_msg') !!}
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif

                            <div class="d-flex justify-content-between product-inner p-b-10">
                                <div class="row-wise-search search-terms">
                                    <input class="form-control mb-1" id="row-wise-search" type="text" placeholder="Search....">
                                </div>
                                <div class="pagination-area mt-xs-10 mb-xs-5">
                                    <form action="" method="post">
                                        <div class="datatable-pages d-flex align-items-center">
                                            <span class="displaying-num">{{$all_category->total()}} items</span>
                                            <span class="pagination-links d-flex">
                                                @if($all_category->currentPage() > 1)
                                                <a class="first-page btn {{$all_category->currentPage() > 1 ? '' : 'disable'}}" href="{{$all_decode_category->first_page_url}}" data-toggle="tooltip" data-placement="top" title="First Page">
                                                    <span class="screen-reader-text d-none">First page</span>
                                                    <span aria-hidden="true">«</span>
                                                </a>
                                                <a class="prev-page btn {{$all_category->currentPage() > 1 ? '' : 'disable'}}" href="{{$all_decode_category->prev_page_url}}" data-toggle="tooltip" data-placement="top" title="Previous Page">
                                                    <span class="screen-reader-text d-none">Previous page</span>
                                                    <span aria-hidden="true">‹</span>
                                                </a>
                                                @endif
                                                <span class="paging-input d-flex align-items-center">
                                                    <label for="current-page-selector" class="screen-reader-text d-none">Current Page</label>
                                                    <input class="current-page" id="current-page-selector" type="text" name="paged" value="{{$all_decode_category->current_page}}" size="3" aria-describedby="table-paging">
                                                    <span class="datatable-paging-text d-flex"> of <span class="total-pages">{{$all_decode_category->last_page}}</span></span>
                                                    <input type="hidden" name="route_name" value="product-draft">
                                                </span>
                                                @if($all_category->currentPage() !== $all_category->lastPage())
                                                <a class="next-page btn" href="{{$all_decode_category->next_page_url}}" data-toggle="tooltip" data-placement="top" title="Next Page">
                                                    <span class="screen-reader-text d-none">Next page</span>
                                                    <span aria-hidden="true">›</span>
                                                </a>
                                                <a class="last-page btn" href="{{$all_decode_category->last_page_url}}" data-toggle="tooltip" data-placement="top" title="Last Page">
                                                    <span class="screen-reader-text d-none">Last page</span>
                                                    <span aria-hidden="true">»</span>
                                                </a>
                                                @endif
                                            </span>
                                        </div>
                                    </form>
                                </div>
                            </div>


                            <table id="table-sort-list" class="category-table w-100">
                                <thead>
                                <tr>
                                    <th>Category Name</th>
                                    <th style="width: 15%">Actions</th>
                                </tr>
                                </thead>
                                <tbody id="table-body">
                                @isset($all_category)
                                    @foreach($all_category as $category)
                                        <tr>
                                            <td>{{$category->category_name}}</td>
                                            <td class="actions" style="width: 15%">
                                                <div class="d-flex justify-content-start">
                                                    {{--                                                <a href="{{url('category/'.$category->id.'/edit')}}" ><button class="vendor_btn_edit btn-primary">Edit</button></a>&nbsp;--}}
                                                    <a class="mr-2" href="#custom-modal{{$category->id}}" data-animation="slit" data-plugin="custommodal" data-overlaySpeed="100" data-overlayColor="#36404a"><button class="btn-size edit-btn" style="cursor: pointer" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-edit" aria-hidden="true"></i></button></a>&nbsp;
                                                    {{--                                                <a href="{{url('category/'.$category->id)}}" ><button class="vendor_btn_view btn-success">View</button></a>&nbsp;--}}
                                                    <form action="{{url('category/'.$category->id)}}" method="post">
                                                        @method('DELETE')
                                                        @csrf
                                                        <a href="#" class="on-default remove-row"><button class="btn-size delete-btn" style="cursor: pointer" onclick="return check_delete('category');" data-toggle="tooltip" data-placement="top" title="Delete"><i class="fa fa-trash" aria-hidden="true"></i></button></a>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>

                                        <!-- Edit Category Modal -->
                                        <div id="custom-modal{{$category->id}}" class="modal-demo">
                                            <button type="button" class="close" onclick="Custombox.close();">
                                                <span>&times;</span><span class="sr-only">Close</span>
                                            </button>
                                            <h4 class="custom-modal-title">Edit Category Name</h4>
                                            <form role="form" class="vendor-form mobile-responsive" action="{{url('category/'.$category->id)}}" method="post">
                                                @method('PUT')
                                                @csrf
                                                <div class="form-group w_category_name row">
                                                    <label for="name" class="col-md-3 col-form-label ml-sm-25 mr-sm-25 ml-xs-25 mr-xs-25 required">Category Name</label>
                                                    <div class="col-md-9 ml-sm-25 mr-sm-25 ml-xs-25 mr-xs-25">
                                                        <input type="text" name="category_name" class="form-control" id="category_name" value="{{ $category->category_name ? $category->category_name :old('category_name') }}" placeholder="Enter category name" required>
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <div class="col-md-12 text-center mb-5 mt-3">
                                                        <button type="submit" class="btn btn-primary vendor-btn waves-effect waves-light">
                                                            <b>Update</b>
                                                        </button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                        <!--End Edit Category Modal -->

                                    @endforeach
                                @endisset
                                </tbody>
                            </table>

                            <!--table below pagination sec-->
                            <div class="row table-foo-sec">
                                <div class="col-md-6 d-flex justify-content-md-start align-items-center"> </div>
                                <div class="col-md-6">
                                    <div class="d-flex justify-content-md-end align-items-center py-2">
                                        <div class="pagination-area">
                                            <div class="datatable-pages d-flex align-items-center">
                                                <span class="displaying-num"> {{$all_category->total()}} items</span>
                                                <span class="pagination-links d-flex">
                                                    @if($all_category->currentPage() > 1)
                                                    <a class="first-page btn {{$all_category->currentPage() > 1 ? '' : 'disable'}}" href="{{$all_decode_category->first_page_url}}" data-toggle="tooltip" data-placement="top" title="First Page">
                                                        <span class="screen-reader-text d-none">First page</span>
                                                        <span aria-hidden="true">«</span>
                                                    </a>
                                                    <a class="prev-page btn {{$all_category->currentPage() > 1 ? '' : 'disable'}}" href="{{$all_decode_category->prev_page_url}}" data-toggle="tooltip" data-placement="top" title="Previous Page">
                                                        <span class="screen-reader-text d-none">Previous page</span>
                                                        <span aria-hidden="true">‹</span>
                                                    </a>
                                                    @endif
                                                    <span class="screen-reader-text" style="display: none;">Current Page</span>
                                                    <span class="paging-input d-flex align-items-center">
                                                        <span class="datatable-paging-text d-flex pl-1"> {{$all_decode_category->current_page}} of <span class="total-pages"> {{$all_decode_category->last_page}} </span></span>
                                                    </span>
                                                    @if($all_category->currentPage() !== $all_category->lastPage())
                                                    <a class="next-page btn" href="{{$all_decode_category->next_page_url}}" data-toggle="tooltip" data-placement="top" title="Next Page">
                                                        <span class="screen-reader-text d-none">Next page</span>
                                                        <span aria-hidden="true">›</span>
                                                    </a>
                                                    <a class="last-page btn" href="{{$all_decode_category->last_page_url}}" data-toggle="tooltip" data-placement="top" title="Last Page">
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





    <!-- Add Category Modal -->
    <div id="addCategory" class="modal-demo">
        <button type="button" class="close" onclick="Custombox.close();">
            <span>&times;</span><span class="sr-only">Close</span>
        </button>
        <h4 class="custom-modal-title">Add Category</h4>
        <form role="form" class="vendor-form mobile-responsive " action="{{url('category')}}" method="post">
            @csrf
            <div class="form-group w_category_name row">
                <label for="name" class="col-md-3 col-form-label ml-sm-25 mr-sm-25 ml-xs-25 mr-xs-25 required">Category Name</label>
                <div class="col-md-9 ml-sm-25 mr-sm-25 ml-xs-25 mr-xs-25">
                    <input type="text" name="category_name" class="form-control" id="category_name" value="{{ old('category_name') }}" placeholder="Enter category name" required>
                </div>
            </div>

            <div class="form-group row">
                <div class="col-md-12 text-center  mb-5 mt-3">
                    <button type="submit" class="btn btn-primary vendor-btn waves-effect waves-light">
                        <b>Submit</b>
                    </button>
                </div>
            </div>
        </form>

    </div>
    <!--End Add Category Modal-->




    <script>

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
