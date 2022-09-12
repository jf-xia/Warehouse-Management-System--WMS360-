
@extends('master')
@section('title')
    Onbuy | Category List | WMS360
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
                <input type="hidden" id="firstKey" value="onbuy">
                <input type="hidden" id="secondKey" value="onbuy_category_list">
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
                                    <a href="#"><button class="btn btn-default onbuy-category-migrate">OnBuy Category Migrate</button></a>&nbsp;
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <!--//screen option-->
                <div class="screen-option">
                    <div class="d-flex justify-content-start align-items-center">
                        <ol class="breadcrumb page-breadcrumb">
                            <li class="breadcrumb-item"> Onbuy </li>
                            <li class="breadcrumb-item active" aria-current="page"> Category List</li>
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

                            @if (Session::has('success'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    {!! Session::get('success') !!}
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif

                            @if (Session::has('error'))
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    {!! Session::get('error') !!}
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
                                    <form action="{{url('pagination-all')}}" method="post">
                                        @csrf
                                        <div class="datatable-pages d-flex align-items-center">
                                            <span class="displaying-num">{{$categories->total()}} items</span>
                                            <span class="pagination-links d-flex">
                                                @if($categories->currentPage() > 1)
                                                <a class="first-page btn {{$categories->currentPage() > 1 ? '' : 'disable'}}" href="{{$decodeCategory->first_page_url}}" data-toggle="tooltip" data-placement="top" title="First Page">
                                                    <span class="screen-reader-text d-none">First page</span>
                                                    <span aria-hidden="true">«</span>
                                                </a>
                                                <a class="prev-page btn {{$categories->currentPage() > 1 ? '' : 'disable'}}" href="{{$decodeCategory->prev_page_url}}" data-toggle="tooltip" data-placement="top" title="Previous Page">
                                                    <span class="screen-reader-text d-none">Previous page</span>
                                                    <span aria-hidden="true">‹</span>
                                                </a>
                                                @endif
                                                <span class="paging-input d-flex align-items-center">
                                                    <label for="current-page-selector" class="screen-reader-text d-none">Current Page</label>
                                                    <input class="current-page" id="current-page-selector" type="text" name="paged" value="{{$decodeCategory->current_page}}" size="3" aria-describedby="table-paging">
                                                    <span class="datatable-paging-text d-flex"> of <span class="total-pages">{{$decodeCategory->last_page}}</span></span>
                                                    <input type="hidden" name="route_name" value="onbuy/category">
                                                </span>
                                                @if($categories->currentPage() !== $categories->lastPage())
                                                <a class="next-page btn" href="{{$decodeCategory->next_page_url}}" data-toggle="tooltip" data-placement="top" title="Next Page">
                                                    <span class="screen-reader-text d-none">Next page</span>
                                                    <span aria-hidden="true">›</span>
                                                </a>
                                                <a class="last-page btn" href="{{$decodeCategory->last_page_url}}" data-toggle="tooltip" data-placement="top" title="Last Page">
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
                                </tr>
                                </thead>
                                <tbody id="table-body">
                                @isset($categories)
                                    @foreach($categories as $category)
                                        <tr>
                                            <td>{{$category->name}}</td>
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
                                        <div class="pagination-area">
                                            <div class="datatable-pages d-flex align-items-center">
                                                <span class="displaying-num"> {{$categories->total()}} items</span>
                                                <span class="pagination-links d-flex">
                                                    @if($categories->currentPage() > 1)
                                                    <a class="first-page btn {{$categories->currentPage() > 1 ? '' : 'disable'}}" href="{{$decodeCategory->first_page_url}}" data-toggle="tooltip" data-placement="top" title="First Page">
                                                        <span class="screen-reader-text d-none">First page</span>
                                                        <span aria-hidden="true">«</span>
                                                    </a>
                                                    <a class="prev-page btn {{$categories->currentPage() > 1 ? '' : 'disable'}}" href="{{$decodeCategory->prev_page_url}}" data-toggle="tooltip" data-placement="top" title="Previous Page">
                                                        <span class="screen-reader-text d-none">Previous page</span>
                                                        <span aria-hidden="true">‹</span>
                                                    </a>
                                                    @endif
                                                    <span class="screen-reader-text" style="display: none;">Current Page</span>
                                                    <span class="paging-input d-flex align-items-center">
                                                        <span class="datatable-paging-text d-flex pl-1"> {{$decodeCategory->current_page}} of <span class="total-pages"> {{$decodeCategory->last_page}} </span></span>
                                                    </span>
                                                    @if($categories->currentPage() !== $categories->lastPage())
                                                    <a class="next-page btn" href="{{$decodeCategory->next_page_url}}" data-toggle="tooltip" data-placement="top" title="Next Page">
                                                        <span class="screen-reader-text d-none">Next page</span>
                                                        <span aria-hidden="true">›</span>
                                                    </a>
                                                    <a class="last-page btn" href="{{$decodeCategory->last_page_url}}" data-toggle="tooltip" data-placement="top" title="Last Page">
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

            $('.onbuy-category-migrate').on('click',function (){
                console.log('found');
                $.ajax({
                    type: 'post',
                    url: '{{url("onbuy/category-migrate")}}',
                    data: {
                        '_token': '{{csrf_token()}}'
                    },
                    beforeSend: function (){
                        $('#ajax_loader').show();
                    },
                    success: function (response){
                        console.log(response);
                        $('#ajax_loader').hide();
                    }
                })
            });
        });

    </script>


@endsection
