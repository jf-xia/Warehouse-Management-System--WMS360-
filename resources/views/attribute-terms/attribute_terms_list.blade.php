@extends('master')

@section('title')
    Catalogue | Attributes | WMS360
@endsection

@section('content')

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
                <input type="hidden" id="firstKey" value="catalogue">
                <input type="hidden" id="secondKey" value="attribute_terms_list">
                <!----END ON OFF SWITCH ARRAY KEY DECLARATION---->

                <!--screen option-->
                <div class="row">
                            <div class="col-md-12">
                                <div class="card-box screen-option-content" style="display: none">
                                <div class="d-flex justify-content-between align-items-center" style="margin-bottom:20px;">
                                <div>
                                <div><p class="pagination"><b>Add Variation</b></p></div>

                                <span class="pagination-mgs-show text-success"></span>
                                </div>
                                <div>
                                    <a href="#addAttribute" data-animation="slit" data-plugin="custommodal" data-overlaySpeed="100" data-overlayColor="#36404a"><button class="btn btn-default">Add Variation</button></a>
                                </div>
                            </div>
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
                                    <a href="#addAttributeTerms" data-animation="slit" data-plugin="custommodal" data-overlaySpeed="100" data-overlayColor="#36404a"><button class="btn btn-default">Add Variation Terms</button></a>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <!--//screen option-->



                <div class="screen-option">

                    <div class="d-flex justify-content-start align-items-center">
                        <ol class="breadcrumb page-breadcrumb">
                                <li class="breadcrumb-item">Catalogue</li>
                            <li class="breadcrumb-item active" aria-current="page">Variation</li>
                        </ol>
                    </div>
                    <div class="screen-option-btn">
                        <button class="btn btn-link waves-effect waves-light" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                            Screen Options &nbsp; <i class="fa" aria-hidden="true"></i>
                        </button>
                        <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion"></div>
                    </div>
                </div>


                <div class="row m-t-20 ">
                    <div class="col-md-12">
                        <div class="card-box table-responsive shadow attribute-terms-card">

                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif


                            @if (Session::has('attribute_terms_add_success_msg'))
                                <div class="alert alert-success">
                                    {!! Session::get('attribute_terms_add_success_msg') !!}
                                </div>
                            @endif

                            @if (Session::has('attribute_terms_add_error_msg'))
                                <div class="alert alert-danger">
                                    {!! Session::get('attribute_terms_add_error_msg') !!}
                                </div>
                            @endif

                            @if (Session::has('attribute_terms_delete_success_msg'))
                                <div class="alert alert-danger">
                                    {!! Session::get('attribute_terms_delete_success_msg') !!}
                                </div>
                            @endif

                            <!-- attribute session messege -->
                            @if (Session::has('attribute_add_success_msg'))
                                <div class="alert alert-success">
                                    {!! Session::get('attribute_add_success_msg') !!}
                                </div>
                            @endif




                            <!-- tab section start from here -->

                <div class="row m-t-20">
                    <div class="col-md-12">
                        <div class="shadow">
                            <ul class="nav nav-tabs" role="tablist" id="attributeTab">

                                    <li class="nav-item text-center" style="width: 50%">
                                        <a class="nav-link active" data-toggle="tab" href="#attribute_list">
                                            Variation
                                        </a>
                                    </li>
                                    <li class="nav-item text-center" style="width: 50%">
                                        <a class="nav-link" data-toggle="tab" href="#attribute_term_list">
                                            Variation Term
                                        </a>
                                    </li>

                            </ul>

                            <div class="tab-content p-50 product-content">

                                <div id="attribute_list" class="tab-pane active m-b-20">

                                    @include('attribute.attribute_list')
                                    <!-- add the tab content here -->
                                </div>

                                <div id="attribute_term_list" class="tab-pane m-b-20">
                                <div class="d-flex justify-content-between product-inner p-b-10">
                                <div class="row-wise-search variation-terms-search">
                                    {{-- <input class="form-control mb-1" id="row-wise-search" type="text" placeholder="Search...."> --}}
                                    <form class="d-flex" action="{{URL('attribute/terms/search')}}" method="post">
                                        @csrf
                                        <div class="p-text-area">
                                            <input type="text" name="attribute_terms_search" id="search_value" class="form-control" placeholder="Search...">
                                        </div>
                                        <div class="submit-btn">
                                            <button type="submit" class="terms-btn waves-effect waves-light" onclick="ebay_profile_search()">Search</button>
                                        </div>
                                    </form>
                                </div>
                                <div class="pagination-area mt-xs-10 mb-xs-5">
                                    <form action="{{url('pagination-all')}}" method="post">
                                        @csrf
                                        <div class="datatable-pages d-flex align-items-center">
                                            <span class="displaying-num">{{$attribute_terms->total()}} items</span>
                                            <span class="pagination-links d-flex">
                                                @if($attribute_terms->currentPage() > 1)
                                                <a class="first-page btn {{$attribute_terms->currentPage() > 1 ? '' : 'disable'}}" href="{{$all_attribute_terms->first_page_url}}" data-toggle="tooltip" data-placement="top" title="First Page">
                                                    <span class="screen-reader-text d-none">First page</span>
                                                    <span aria-hidden="true">«</span>
                                                </a>
                                                <a class="prev-page btn {{$attribute_terms->currentPage() > 1 ? '' : 'disable'}}" href="{{$all_attribute_terms->prev_page_url}}" data-toggle="tooltip" data-placement="top" title="Previous Page">
                                                    <span class="screen-reader-text d-none">Previous page</span>
                                                    <span aria-hidden="true">‹</span>
                                                </a>
                                                @endif
                                                <span class="paging-input d-flex align-items-center">
                                                    <label for="current-page-selector" class="screen-reader-text d-none">Current Page</label>
                                                    <input class="current-page" id="current-page-selector" type="text" name="paged" value="{{$all_attribute_terms->current_page}}" size="3" aria-describedby="table-paging">
                                                    <span class="datatable-paging-text d-flex"> of <span class="total-pages">{{$all_attribute_terms->last_page}}</span></span>
                                                    <input type="hidden" name="route_name" value="attribute-terms">
                                                </span>
                                                @if($attribute_terms->currentPage() !== $attribute_terms->lastPage())
                                                <a class="next-page btn" href="{{$all_attribute_terms->next_page_url}}" data-toggle="tooltip" data-placement="top" title="Next Page">
                                                    <span class="screen-reader-text d-none">Next page</span>
                                                    <span aria-hidden="true">›</span>
                                                </a>
                                                <a class="last-page btn" href="{{$all_attribute_terms->last_page_url}}" data-toggle="tooltip" data-placement="top" title="Last Page">
                                                    <span class="screen-reader-text d-none">Last page</span>
                                                    <span aria-hidden="true">»</span>
                                                </a>
                                                @endif
                                            </span>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <table id="table-sort-list" class="attribute-table w-100">
                                <thead>
                                <tr>
                                    <th style="width: 45%">Terms Name</th>
                                    <th style="width: 45%">Variation Name</th>
                                    <th style="width: 10%">Actions</th>
                                </tr>
                                </thead>
                                <tbody id="table-body">
                                    @foreach($attribute_terms as $attribute_terms)
                                        <tr>
                                            <td style="width: 45%">{{$attribute_terms->terms_name}}</td>
                                            <td style="width: 45%">{{$attribute_terms->attribute->attribute_name}}</td>
                                            <td class="actions" style="width: 10%">
{{--                                                <a href="{{url('attribute-terms/'.$attribute_terms->id.'/edit')}}" ><button class="vendor_btn_edit btn-primary">Edit</button></a>&nbsp;--}}
                                                <a href="#" ><button class="btn-size view-btn" style="cursor: pointer;"  data-toggle="tooltip" data-placement="top" title="View"><i class="fa fa-eye" aria-hidden="true"></i></button></a>&nbsp;
{{--                                                <form action="{{url('attribute-terms/'.$attribute_terms->attribute_id.'-'.$attribute_terms->id)}}" method="post">--}}
{{--                                                    @method('DELETE')--}}
{{--                                                    @csrf--}}
{{--                                                    <a href="#" class="on-default remove-row" ><button class="vendor_btn_delete btn-danger" onclick="return check_delete('attribute terms');">Delete</button>  </a>--}}

{{--                                                </form>--}}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            <!--table below pagination sec-->
                            <div class="row table-foo-sec">
                                <div class="col-md-6 d-flex justify-content-md-start align-items-center">

                                </div>
                                <div class="col-md-6">
                                    <div class="d-flex justify-content-md-end align-items-center py-2">
                                        <div class="pagination-area">
                                            <div class="datatable-pages d-flex align-items-center">
                                                <span class="displaying-num">{{$total_attribute_terms}} items</span>
                                                <span class="pagination-links d-flex">
                                                    <a class="first-page btn" href="{{$all_attribute_terms->first_page_url}}" data-toggle="tooltip" data-placement="top" title="First Page">
                                                        <span class="screen-reader-text d-none">First page</span>
                                                        <span aria-hidden="true">«</span>
                                                    </a>
                                                    <a class="prev-page btn" href="{{$all_attribute_terms->prev_page_url}}" data-toggle="tooltip" data-placement="top" title="Previous Page">
                                                        <span class="screen-reader-text d-none">Previous page</span>
                                                        <span aria-hidden="true">‹</span>
                                                    </a>
                                                    <span class="screen-reader-text" style="display: none;">Current Page</span>
                                                    <span class="paging-input d-flex align-items-center">
                                                        <span class="datatable-paging-text d-flex pl-1"> {{$all_attribute_terms->current_page}} of <span class="total-pages"> {{$all_attribute_terms->last_page}} </span></span>
                                                    </span>
                                                    <a class="next-page btn" href="{{$all_attribute_terms->next_page_url}}" data-toggle="tooltip" data-placement="top" title="Next Page">
                                                        <span class="screen-reader-text d-none">Next page</span>
                                                        <span aria-hidden="true">›</span>
                                                    </a>
                                                    <a class="last-page btn" href="{{$all_attribute_terms->last_page_url}}" data-toggle="tooltip" data-placement="top" title="Last Page">
                                                        <span class="screen-reader-text d-none">Last page</span>
                                                        <span aria-hidden="true">»</span>
                                                    </a>
                                               </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--End table below pagination sec-->
                                    <!-- add the tab content here -->

                                </div>

                            </div>
                        </div>
                    </div> <!-- end col -->
                </div>
                            <!-- tab section end from here -->






                        </div>
                    </div>
                </div> <!-- end row -->
            </div> <!-- container -->
        </div> <!-- content -->
    </div>

 <!-- Add Attribute  Modal -->
 <div id="addAttribute" class="modal-demo">
        <button type="button" class="close" onclick="Custombox.close();">
            <span>&times;</span><span class="sr-only">Close</span>
        </button>
        <h4 class="custom-modal-title">Add Variation</h4>

        <form role="form" class="vendor-form mobile-responsive" action="{{url('attribute')}}" method="post">
            @csrf
            <div class="form-group c_attribute_terms row">
                <label for="name" class="col-md-4 col-form-label ml-sm-25 mr-sm-25 ml-xs-25 mr-xs-25 required">Use as woocommerce variation ?</label>
                <div class="col-md-8 ml-sm-25 mr-sm-25 ml-xs-25 mr-xs-25">
                        <div class="col-md-4">
                            <input type="radio" name="use_variation" class="form-control" id="use_variation" value="1" style="width: 50px; display: initial;"><span>Yes</span>
                            <input type="radio" name="use_variation" class="form-control" id="use_variation" value="0" style="width: 50px; display: initial;"><span>No</span>
                        </div>
                </div>
            </div>
            <div class="form-group c_attribute_terms row">
                <label for="name" class="col-md-4 col-form-label ml-sm-25 mr-sm-25 ml-xs-25 mr-xs-25 required">Variation Name</label>
                <div class="col-md-8 ml-sm-25 mr-sm-25 ml-xs-25 mr-xs-25">

                    <div class="col-md-8">
                        <input type="text" name="attribute_name" class="form-control" id="attribute_name" value="{{ old('attribute_name') }}" placeholder="Enter Variation Name" required>
                    </div>
                </div>

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
    <!--End Add Attribute  Modal-->



    <!-- Add Attribute Terms Modal -->
    <div id="addAttributeTerms" class="modal-demo">
        <button type="button" class="close" onclick="Custombox.close();">
            <span>&times;</span><span class="sr-only">Close</span>
        </button>
        <h4 class="custom-modal-title">Add Variation Terms</h4>

        <form role="form" class="vendor-form mobile-responsive" action="{{url('attribute-terms')}}" method="post">
            @csrf
            <div class="form-group c_attribute_terms row">
                <label for="name" class="col-md-4 col-form-label ml-sm-25 mr-sm-25 ml-xs-25 mr-xs-25 required">Variation</label>
                <div class="col-md-8 ml-sm-25 mr-sm-25 ml-xs-25 mr-xs-25">
                    <select name="attribute_id" id="attribute_id" class="form-control" required>
                        <option value="">Select Variation</option>
                        @isset($all_attribute)
                            @foreach($all_attribute as $attribute)
                                <option value="{{$attribute->id}}">{{$attribute->attribute_name}}</option>
                            @endforeach
                        @endisset
                    </select>
                </div>
            </div>
            <div class="form-group c_attribute_terms row">
                <label for="name" class="col-md-4 col-form-label ml-sm-25 mr-sm-25 ml-xs-25 mr-xs-25 required">Variation Terms Name</label>
                <div class="col-md-8 ml-sm-25 mr-sm-25 ml-xs-25 mr-xs-25 more-terms-append-div">
                    <div class="input-group">
                        <input type="text" name="terms_name[]" class="form-control mb-2" id="terms_name" value="{{ old('terms_name') }}" placeholder="Enter Variation Terms Name" required>
                        <!-- <span class="input-group-btn">
                            <button class="btn btn-info add-more-terms-field"><i class="fa fa-plus"></i></button>
                        </span> -->
                    </div>
                </div>

            </div>
            <div class="form-group row c_attribute_terms">
                <div class="col-md-8 offset-md-4">
                    <span class="float-right">
                        <button class="btn btn-info add-more-terms-field"><i class="fa fa-plus"></i></button>
                    </span>
                </div>
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
    <!--End Add Attribute Terms Modal-->



    <script>

        //Datatable row-wise searchable option
        $(document).ready(function(){
            $("#row-wise-search").on("keyup", function() {
                let value = $(this).val().toLowerCase();
                $("#table-body tr").filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });

            });
            $('.add-more-terms-field').click(function(event){
                event.preventDefault()
                var html = '<div class="input-group">'
                        +'<input type="text" name="terms_name[]" class="form-control mb-2" id="terms_name" value="{{ old('terms_name') }}" placeholder="Enter Variation Terms Name" required>'
                        +'<span class="input-group-btn">'
                        +    '<button class="btn btn-danger remove-more-terms-field"><i class="fa fa-remove"></i></button>'
                        +'</span>'
                    +'</div>'
                $('.more-terms-append-div').append(html)
                console.log('found')
            })
            $('.form-group').on('click','.remove-more-terms-field',function(event){
                event.preventDefault()
                console.log('remove found')
                $(this).closest('div').remove()
            })
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

        // on load page current tab


    $(document).ready(function(){
        $('a[data-toggle="tab"]').on('show.bs.tab', function(e) {
            localStorage.setItem('activeTab', $(e.target).attr('href'));
        });
        var activeTab = localStorage.getItem('activeTab');
        if(activeTab){
            $('#attributeTab a[href="' + activeTab + '"]').tab('show');
        }
    });

    </script>

@endsection
